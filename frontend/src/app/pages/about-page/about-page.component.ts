import { Component } from '@angular/core';
import { LandingPageComponent } from '../landing-page/landing-page.component';

@Component({
  selector: 'app-about-page',
  standalone: true,
  imports: [LandingPageComponent],
  template: '<app-landing-page></app-landing-page>'
})
export class AboutPageComponent {}
