import './bootstrap';

const toggleHidden = (element, force) => {
    if (!element) {
        return;
    }

    if (typeof force === 'boolean') {
        element.classList.toggle('hidden', !force);
        return;
    }

    element.classList.toggle('hidden');
};

const splitTargets = (value = '') =>
    value
        .split(',')
        .map((entry) => entry.trim())
        .filter(Boolean);

const setMobileMenuState = (menu, button, open) => {
    if (!menu || !button) {
        return;
    }

    menu.classList.toggle('border-t', open);
    menu.classList.toggle('border-gray-100', open);
    menu.classList.toggle('shadow-lg', open);
    menu.classList.toggle('max-h-screen', open);
    menu.classList.toggle('opacity-100', open);
    menu.classList.toggle('pointer-events-none', !open);
    menu.classList.toggle('max-h-0', !open);
    menu.classList.toggle('opacity-0', !open);
    button.setAttribute('aria-expanded', open ? 'true' : 'false');

    const menuIcon = button.querySelector('[data-menu-icon]');
    const closeIcon = button.querySelector('[data-close-icon]');
    toggleHidden(menuIcon, !open);
    toggleHidden(closeIcon, open);
};

const checkIconMarkup =
    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';

const setupRevealAnimations = () => {
    const revealElements = Array.from(document.querySelectorAll('[data-reveal]'));

    if (!revealElements.length) {
        return;
    }

    if (typeof window.IntersectionObserver === 'undefined') {
        revealElements.forEach((element) => element.classList.add('reveal-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('reveal-visible');
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.15,
        }
    );

    revealElements.forEach((element) => observer.observe(element));
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-toggle-target]').forEach((button) => {
        button.addEventListener('click', () => {
            splitTargets(button.getAttribute('data-toggle-target')).forEach((target) => {
                toggleHidden(document.querySelector(target));
            });
        });
    });

    const scrollNavs = Array.from(document.querySelectorAll('[data-scroll-nav]'));
    const onScroll = () => {
        const scrolled = window.scrollY > 20;
        scrollNavs.forEach((nav) => {
            nav.classList.toggle('bg-white/95', scrolled);
            nav.classList.toggle('backdrop-blur-md', scrolled);
            nav.classList.toggle('shadow-sm', scrolled);
            nav.classList.toggle('border-b', scrolled);
            nav.classList.toggle('border-gray-100', scrolled);

            nav.querySelectorAll('[data-scroll-link]').forEach((link) => {
                link.classList.toggle('text-gray-600', scrolled);
                link.classList.toggle('text-gray-700', !scrolled);
            });
        });
    };
    window.addEventListener('scroll', onScroll);
    onScroll();

    document.querySelectorAll('[data-mobile-menu-button]').forEach((button) => {
        const target = button.getAttribute('data-mobile-menu-target');
        const menu = target ? document.querySelector(target) : null;
        if (!menu) {
            return;
        }

        setMobileMenuState(menu, button, false);

        button.addEventListener('click', () => {
            const open = button.getAttribute('aria-expanded') !== 'true';
            setMobileMenuState(menu, button, open);
        });

        menu.querySelectorAll('[data-mobile-close]').forEach((link) => {
            link.addEventListener('click', () => setMobileMenuState(menu, button, false));
        });
    });

    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-password-toggle');
            const input = target ? document.querySelector(target) : null;
            if (!input) {
                return;
            }

            const visible = input.getAttribute('type') === 'text';
            input.setAttribute('type', visible ? 'password' : 'text');

            const showIcon = button.querySelector('[data-password-icon="show"]');
            const hideIcon = button.querySelector('[data-password-icon="hide"]');
            toggleHidden(showIcon, visible);
            toggleHidden(hideIcon, !visible);
        });
    });

    document.querySelectorAll('[data-demo-login]').forEach((button) => {
        button.addEventListener('click', () => {
            const email = button.getAttribute('data-demo-email') || '';
            const password = button.getAttribute('data-demo-password') || '';
            const path = button.getAttribute('data-demo-path') || '';
            const container = button.closest('[data-demo-container]') || document;
            const emailInput = container.querySelector('#email');
            const passwordInput = container.querySelector('#password');

            if (emailInput) {
                emailInput.value = email;
                emailInput.dispatchEvent(new Event('input', { bubbles: true }));
            }

            if (passwordInput) {
                passwordInput.value = password;
                passwordInput.dispatchEvent(new Event('input', { bubbles: true }));
            }

            if (path) {
                window.setTimeout(() => {
                    window.location.href = path;
                }, 300);
            }
        });
    });

    document.querySelectorAll('[data-modal-open]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-modal-open');
            const modal = target ? document.querySelector(target) : null;
            toggleHidden(modal, true);
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-modal-close');
            if (target) {
                splitTargets(target).forEach((selector) => {
                    toggleHidden(document.querySelector(selector), false);
                });
                return;
            }

            toggleHidden(button.closest('[data-modal]'), false);
        });
    });

    document.querySelectorAll('[data-tab-group]').forEach((group) => {
        const buttons = Array.from(group.querySelectorAll('[data-tab-target]'));
        const panels = Array.from(group.querySelectorAll('[data-tab-panel]'));

        const setActive = (targetId) => {
            panels.forEach((panel) => {
                toggleHidden(panel, panel.getAttribute('data-tab-panel') === targetId);
            });

            buttons.forEach((button) => {
                const active = button.getAttribute('data-tab-target') === targetId;
                const activeClasses = (button.getAttribute('data-active-classes') || '').split(' ').filter(Boolean);
                const inactiveClasses = (button.getAttribute('data-inactive-classes') || '').split(' ').filter(Boolean);
                activeClasses.forEach((className) => button.classList.toggle(className, active));
                inactiveClasses.forEach((className) => button.classList.toggle(className, !active));
            });
        };

        buttons.forEach((button) => {
            button.addEventListener('click', () => setActive(button.getAttribute('data-tab-target')));
        });

        const initial = group.getAttribute('data-tab-initial') || buttons[0]?.getAttribute('data-tab-target');
        if (initial) {
            setActive(initial);
        }
    });

    document.querySelectorAll('[data-stepper]').forEach((stepper) => {
        const steps = Array.from(stepper.querySelectorAll('[data-step]'));
        const indicators = Array.from(stepper.querySelectorAll('[data-step-indicator]'));
        const labels = Array.from(stepper.querySelectorAll('[data-step-label]'));
        const connectors = Array.from(stepper.querySelectorAll('[data-step-connector]'));

        const setStep = (value) => {
            const current = Number.parseInt(String(value), 10);

            steps.forEach((step) => {
                const active = step.getAttribute('data-step') === String(current);
                toggleHidden(step, active);
                if (active) {
                    step.classList.remove('surface-fade-up');
                    void step.offsetWidth;
                    step.classList.add('surface-fade-up');
                }
            });

            indicators.forEach((indicator) => {
                const stepNumber = Number.parseInt(indicator.getAttribute('data-step-indicator') || '0', 10);
                const completed = current > stepNumber;
                const active = current === stepNumber;

                indicator.classList.toggle('bg-blue-600', completed || active);
                indicator.classList.toggle('text-white', completed || active);
                indicator.classList.toggle('bg-gray-200', !completed && !active);
                indicator.classList.toggle('text-gray-400', !completed && !active);
                indicator.innerHTML = completed ? checkIconMarkup : indicator.getAttribute('data-step-number') || String(stepNumber);
            });

            labels.forEach((label) => {
                const stepNumber = Number.parseInt(label.getAttribute('data-step-label') || '0', 10);
                label.classList.toggle('text-gray-900', current >= stepNumber);
                label.classList.toggle('text-gray-400', current < stepNumber);
            });

            connectors.forEach((connector) => {
                const stepNumber = Number.parseInt(connector.getAttribute('data-step-connector') || '0', 10);
                connector.classList.toggle('bg-blue-600', current > stepNumber);
                connector.classList.toggle('bg-gray-200', current <= stepNumber);
            });
        };

        stepper.querySelectorAll('[data-step-next]').forEach((button) => {
            button.addEventListener('click', () => {
                const current = Number.parseInt(stepper.getAttribute('data-step-current') || '1', 10);
                const next = Math.min(current + 1, steps.length);
                stepper.setAttribute('data-step-current', String(next));
                setStep(next);
            });
        });

        stepper.querySelectorAll('[data-step-prev]').forEach((button) => {
            button.addEventListener('click', () => {
                const current = Number.parseInt(stepper.getAttribute('data-step-current') || '1', 10);
                const previous = Math.max(current - 1, 1);
                stepper.setAttribute('data-step-current', String(previous));
                setStep(previous);
            });
        });

        setStep(stepper.getAttribute('data-step-current') || '1');
    });

    document.querySelectorAll('[data-plan-picker]').forEach((picker) => {
        const refresh = () => {
            picker.querySelectorAll('[data-plan-card]').forEach((card) => {
                const input = card.querySelector('input[name="plan"]');
                const active = Boolean(input?.checked);
                card.classList.toggle('border-blue-600', active);
                card.classList.toggle('bg-blue-50/50', active);
                card.classList.toggle('border-gray-200', !active);
                card.classList.toggle('hover:border-gray-300', !active);
            });
        };

        picker.querySelectorAll('input[name="plan"]').forEach((input) => {
            input.addEventListener('change', refresh);
        });

        refresh();
    });

    document.querySelectorAll('[data-billing-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const mode = button.getAttribute('data-billing-toggle');
            const container = button.closest('[data-billing]');
            if (!container || !mode) {
                return;
            }

            container.setAttribute('data-billing', mode);
            container.querySelectorAll('[data-billing-monthly]').forEach((element) => {
                toggleHidden(element, mode === 'monthly');
            });
            container.querySelectorAll('[data-billing-annual]').forEach((element) => {
                toggleHidden(element, mode === 'annual');
            });
            container.querySelectorAll('[data-billing-button]').forEach((toggle) => {
                const active = toggle.getAttribute('data-billing-toggle') === mode;
                toggle.classList.toggle('bg-white', active);
                toggle.classList.toggle('shadow-sm', active);
                toggle.classList.toggle('text-gray-900', active);
                toggle.classList.toggle('text-gray-500', !active);
            });
        });
    });

    document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-sidebar-toggle');
            const sidebar = target ? document.querySelector(target) : null;
            if (!sidebar) {
                return;
            }

            const collapsed = sidebar.getAttribute('data-collapsed') === 'true';
            sidebar.setAttribute('data-collapsed', collapsed ? 'false' : 'true');
            sidebar.classList.toggle('w-[68px]', !collapsed);
            sidebar.classList.toggle('w-64', collapsed);
            sidebar.querySelectorAll('[data-sidebar-label]').forEach((element) => {
                toggleHidden(element, collapsed);
            });
            sidebar.querySelectorAll('[data-sidebar-company]').forEach((element) => {
                toggleHidden(element, collapsed);
            });

            const spacer = document.querySelector('[data-sidebar-spacer]');
            if (spacer) {
                spacer.classList.toggle('w-[68px]', !collapsed);
                spacer.classList.toggle('w-64', collapsed);
            }
        });
    });

    setupRevealAnimations();
});

