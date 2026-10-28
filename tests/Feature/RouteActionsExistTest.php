<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Routes must point at methods that exist.
 *
 * ⚠️ A route whose controller method is missing is a 500 waiting for its first
 * visitor, and nothing else catches it. In user-resume this exact shape shipped
 * three times: resume.index (live 500 on production, measured 2026-10-27), plus
 * role.show and permission.show, all three declared by a bare Route::resource on a
 * controller with no such method.
 *
 * This repo's sweep was clean when the test was added on 2026-10-28. The point is to
 * keep it that way, since nothing links to a dead route until someone types the URL.
 */
class RouteActionsExistTest extends TestCase
{
    public function test_every_controller_route_points_at_a_real_method(): void
    {
        $checked = 0;
        $missing = [];

        foreach (Route::getRoutes() as $route) {
            $action = $route->getAction('uses');

            if (! is_string($action) || ! str_contains($action, '@')) {
                continue;
            }

            $checked++;

            [$class, $method] = explode('@', $action, 2);

            if (! class_exists($class)) {
                $missing[] = $action.'  (class missing)';

                continue;
            }

            if (! method_exists($class, $method)) {
                $missing[] = $action;
            }
        }

        // ⚠️ A premise. Without it this passes identically on a run that swept nothing
        // at all, and an empty sweep reads exactly like a clean one.
        $this->assertGreaterThan(
            10,
            $checked,
            "only {$checked} controller routes were swept; the route list did not load"
        );

        $this->assertSame([], $missing, "routes point at methods that do not exist:\n".implode("\n", $missing));
    }
}
