import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-register-page',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './register-page.component.html',
  styleUrls: ['./register-page.component.css']
})
export class RegisterPageComponent {
  step: number = 1;
  formData = {
    companyName: '',
    companyEmail: '',
    companyPhone: '',
    ownerName: '',
    ownerEmail: '',
    password: '',
    confirmPassword: '',
    plan: 'pro'
  };

  steps = [
    { num: 1, label: 'Company' },
    { num: 2, label: 'Account' },
    { num: 3, label: 'Plan' }
  ];

  constructor(private router: Router) {}

  updateField(field: string, value: string): void {
    this.formData = { ...this.formData, [field]: value };
  }

  setStep(step: number): void {
    this.step = step;
  }

  getStepClass(stepNum: number): string {
    return this.step >= stepNum ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400';
  }

  getStepLabelClass(stepNum: number): string {
    return this.step >= stepNum ? 'text-gray-900' : 'text-gray-400';
  }

  getConnectorClass(stepNum: number): string {
    return this.step > stepNum ? 'bg-blue-600' : 'bg-gray-200';
  }

  getPlanClass(planName: string): string {
    return this.formData.plan === planName ? 'border-blue-600 bg-blue-50/50' : 'border-gray-200 hover:border-gray-300';
  }
}
