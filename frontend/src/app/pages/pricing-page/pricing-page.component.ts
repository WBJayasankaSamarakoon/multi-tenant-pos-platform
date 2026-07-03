import { Component, HostListener, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-pricing-page',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './pricing-page.component.html',
  styleUrls: ['./pricing-page.component.css']
})
export class PricingPageComponent implements OnInit {
  annual = false;
  scrolled = false;
  mobileOpen = false;
  backendLoginUrl = 'http://localhost:8000/login';
  backendRegisterUrl = 'http://localhost:8000/register';

  ngOnInit(): void {
    this.updateScrolledState();
  }

  @HostListener('window:scroll')
  onWindowScroll(): void {
    this.updateScrolledState();
  }

  toggleAnnual(value: boolean): void {
    this.annual = value;
  }

  toggleMobileMenu(): void {
    this.mobileOpen = !this.mobileOpen;
  }

  closeMobileMenu(): void {
    this.mobileOpen = false;
  }

  private updateScrolledState(): void {
    if (typeof window === 'undefined') {
      return;
    }

    this.scrolled = window.scrollY > 20;
  }
}
