import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink, Router } from '@angular/router';
import { FormsModule } from '@angular/forms';

interface DemoCredential {
  role: string;
  email: string;
  password: string;
  color: string;
  path: string;
}

@Component({
  selector: 'app-login-page',
  standalone: true,
  imports: [CommonModule, RouterLink, FormsModule],
  templateUrl: './login-page.component.html',
  styleUrls: ['./login-page.component.css']
})
export class LoginPageComponent {
  email: string = '';
  password: string = '';
  showPassword: boolean = false;
  rememberMe: boolean = false;

  demoCredentials: DemoCredential[] = [
    {
      role: 'Business Owner',
      email: 'owner@demo.lk',
      password: 'demo1234',
      color: 'bg-blue-100 text-blue-700',
      path: '/owner'
    },
    {
      role: 'Cashier',
      email: 'cashier@demo.lk',
      password: 'demo1234',
      color: 'bg-emerald-100 text-emerald-700',
      path: '/cashier'
    },
    {
      role: 'Manager',
      email: 'manager@demo.lk',
      password: 'demo1234',
      color: 'bg-amber-100 text-amber-700',
      path: '/manager'
    },
    {
      role: 'Platform Admin',
      email: 'admin@demo.lk',
      password: 'demo1234',
      color: 'bg-purple-100 text-purple-700',
      path: '/admin'
    }
  ];

  constructor(private router: Router) {}

  handleDemoLogin(cred: DemoCredential): void {
    this.email = cred.email;
    this.password = cred.password;
    setTimeout(() => this.router.navigate([cred.path]), 300);
  }

  handleSubmit(): void {
    const match = this.demoCredentials.find((c) => c.email === this.email);
    if (match) {
      this.router.navigate([match.path]);
    } else {
      this.router.navigate(['/owner']);
    }
  }

  togglePasswordVisibility(): void {
    this.showPassword = !this.showPassword;
  }

  getCredentialClass(color: string): string {
    return `text-xs font-semibold px-2 py-0.5 rounded-full ${color}`;
  }
}
