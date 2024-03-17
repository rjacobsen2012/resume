import {ref} from "vue";

const selectedTheme = ref(null);

// export const setTheme = (theme) => {
//     selectedTheme.value = theme;
//     toggleTheme(theme);
// };
//
// const toggleTheme = (theme) => {
//     if (theme === 'dark') {
//         document.documentElement.classList.add('dark');
//     } else {
//         document.documentElement.classList.remove('dark');
//     }
// };

export function updateThemeInformation(form, user)  {
    if (user) {
        form.post(route('user-theme.update', [user.id]), {
            errorBag: 'updateThemeInformation',
            preserveScroll: true,
        });
    }
}
