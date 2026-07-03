import {
  AfterViewInit,
  Component,
  ElementRef,
  HostListener,
  OnDestroy,
  OnInit,
  inject
} from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-landing-page',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './landing-page.component.html',
  styleUrls: ['./landing-page.component.css']
})
export class LandingPageComponent implements OnInit, AfterViewInit, OnDestroy {
  private readonly elementRef = inject(ElementRef<HTMLElement>);
  private revealObserver?: IntersectionObserver;

  backendLoginUrl = 'http://localhost:8000/login';
  backendRegisterUrl = 'http://localhost:8000/register';
  scrolled = false;
  mobileOpen = false;

  ngOnInit(): void {
    this.updateScrolledState();
  }

  ngAfterViewInit(): void {
    this.setupRevealAnimations();
  }

  ngOnDestroy(): void {
    this.revealObserver?.disconnect();
  }

  @HostListener('window:scroll')
  onWindowScroll(): void {
    this.updateScrolledState();
  }

  toggleMobileMenu(): void {
    this.mobileOpen = !this.mobileOpen;
  }

  closeMobileMenu(): void {
    this.mobileOpen = false;
  }

  private setupRevealAnimations(): void {
    if (typeof window === 'undefined') {
      return;
    }

    const host = this.elementRef.nativeElement as HTMLElement;
    const revealElements = Array.from(host.querySelectorAll('[data-reveal]')) as HTMLElement[];

    if (!revealElements.length) {
      return;
    }

    if (typeof IntersectionObserver === 'undefined') {
      revealElements.forEach((element: HTMLElement) => element.classList.add('reveal-visible'));
      return;
    }

    this.revealObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) {
            return;
          }

          entry.target.classList.add('reveal-visible');
          this.revealObserver?.unobserve(entry.target);
        });
      },
      {
        threshold: 0.15
      }
    );

    revealElements.forEach((element: HTMLElement) => this.revealObserver?.observe(element));
  }

  private updateScrolledState(): void {
    if (typeof window === 'undefined') {
      return;
    }

    this.scrolled = window.scrollY > 20;
  }
}
