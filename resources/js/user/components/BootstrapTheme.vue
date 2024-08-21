<template>
    <div class="nav-item dropdown me-3">
        <button class="btn btn-link nav-link dropdown-toggle d-flex align-items-center" id="bd-theme" data-bs-theme="switcher" type="button" aria-expanded="false" data-bs-toggle="dropdown">
            <i :class="icons[active]"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <button type="button" :class="'dropdown-item d-flex align-items-center '+(active === 'light' ? 'active' : '')"
                        data-bs-theme-value="light" :aria-pressed="active === 'light' ? 'true' : 'false'" @click="changedTheme('light')">
                    <i :class="icons.light+' me-2'"></i> Light
                </button>
            </li>
            <li>
                <button type="button" :class="'dropdown-item d-flex align-items-center '+(active === 'dark' ? 'active' : '')"
                        data-bs-theme-value="dark" :aria-pressed="active === 'dark' ? 'true' : 'false'" @click="changedTheme('dark')">
                    <i :class="icons.dark+' me-2'"></i> Dark
                </button>
            </li>
            <li>
                <button type="button" :class="'dropdown-item d-flex align-items-center '+(active === 'auto' ? 'active' : '')"
                        data-bs-theme-value="auto" :aria-pressed="active === 'auto' ? 'true' : 'false'" @click="changedTheme('auto')">
                    <i :class="icons.auto+' me-2'"></i> Auto
                </button>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    props: {
        theme: {
            type: String,
            required: true,
            default: 'auto',
        }
    },
    data() {
        return {
            storage_key: 'bs_theme',
            icons: {
                light: 'fas fa-fw fa-sun',
                dark: 'fas fa-fw fa-moon',
                auto: 'fas fa-fw fa-circle-half-stroke',
            },
            active: 'auto',
        }
    },
    mounted() {
        this.active = this.theme;
        this.setStoredTheme(this.theme);
        this.changeHtmlTheme(this.theme);

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            const storedTheme = this.getStoredTheme();
            if (storedTheme !== 'light' && storedTheme !== 'dark') {
                this.changeHtmlTheme(this.getPreferredTheme());
            }
        });
    },
    methods: {
        getPreferredTheme() {
            return this.getStoredTheme() ?? this.theme ?? 'auto';
        },
        getStoredTheme() {
            return localStorage.getItem(this.storage_key);
        },
        setStoredTheme(_theme) {
            localStorage.setItem(this.storage_key, _theme);
        },
        changeHtmlTheme(_theme) {
            if (_theme === 'auto') {
                document.documentElement.setAttribute('data-bs-theme', (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'));
            } else {
                document.documentElement.setAttribute('data-bs-theme', _theme);
            }
        },
        changedTheme(_theme) {
            this.setStoredTheme(_theme);
            this.changeHtmlTheme(_theme);
            this.active = _theme;
            axios.put('/api/user/theme', {theme:_theme});
        },
    }
}
</script>
