import {useToast} from "vue-toast-notification";

export function flashSuccess(status) {
    const $toast = useToast();
    $toast.success(status)
}

export function flashError(status) {
    const $toast = useToast();
    $toast.error(status);
}
