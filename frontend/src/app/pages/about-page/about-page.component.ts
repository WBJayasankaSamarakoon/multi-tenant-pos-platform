import { Component, HostListener, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-about-page',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './about-page.component.html',
  styleUrls: ['./about-page.component.css']
})
export class AboutPageComponent implements OnInit {
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
