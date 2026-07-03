import { Routes } from '@angular/router';
import { LandingPageComponent } from './pages/landing-page/landing-page.component';
import { PricingPageComponent } from './pages/pricing-page/pricing-page.component';
import { FeaturesPageComponent } from './pages/features-page/features-page.component';
import { AboutPageComponent } from './pages/about-page/about-page.component';

export const routes: Routes = [
  { path: '', component: LandingPageComponent },
  { path: 'features', component: FeaturesPageComponent },
  { path: 'pricing', component: PricingPageComponent },
  { path: 'about', component: AboutPageComponent },
  { path: '**', redirectTo: '' },
];
