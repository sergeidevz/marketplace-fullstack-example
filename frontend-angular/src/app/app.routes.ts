import { Routes } from '@angular/router';
import { WelcomeComponent } from './pages/welcome.component';
import { LoginComponent } from './pages/login.component';
import { AdsComponent } from './pages/ads.component';
import { ProfileComponent } from './pages/profile.component';
import { AdManagementComponent } from './pages/ad-management.component';
import { NotFoundComponent } from './pages/not-found.component';

export const routes: Routes = [
  {
    path: '',
    component: WelcomeComponent,
  },
  {
    path: 'login',
    component: LoginComponent,
  },
  {
    path: 'listings',
    component: AdsComponent,
  },
  {
    path: 'manage-listings',
    component: AdManagementComponent,
  },
  {
    path: 'profile',
    component: ProfileComponent,
  },
  {
    path: "**",
    component: NotFoundComponent
  }
];
