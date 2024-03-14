import {ref} from "vue";

const selectedTheme = ref(null);

export const setTheme = (theme) => {
    selectedTheme.value = theme;
    toggleTheme(theme);
};

export function getTheme() {
    return selectedTheme;
}

const toggleTheme = (theme) => {
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

export function updateThemeInformation(form, user, theme)  {
    form.post(route('user-theme.update', [user.id]), {
        errorBag: 'updateThemeInformation',
        preserveScroll: true,
        onSuccess: () => setTheme(theme),
    });
}
