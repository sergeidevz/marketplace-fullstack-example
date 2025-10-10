import { Component, inject } from '@angular/core';
import { AuthService } from '../service-singletons/auth.service';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-header',
  imports: [RouterLink],
  styles: `
    :host {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: teal;
      padding: 5px;
      gap: 5px;
    }

    .logo {
      color: white;
      font-weight: bold;
      font-size: 1rem;
    }

    .nav-list {
      display: flex;
      gap: 20px;
      font-size: 1rem;

      a {
        color: white;

        &:hover {
          color: yellow;
        }
      }
    }
  `,
  template: `
    @let isAuth = isAuthenticated();

    <span class="logo">Marketplace</span>
    <nav>
      <ul class="nav-list">
        <li><a routerLink="/listings">Listings</a></li>
        @if (isAuth) {
          <li><a routerLink="/manage-listings">Your listings</a></li>
          <li><a routerLink="/profile">Profile</a></li>
          <li><a href="" (click)="onLogout()">Logout</a></li>
        } @else {
          <li><a routerLink="/login">Login</a></li>
        }
      </ul>
    </nav>
  `,
})
export class HeaderComponent {
  #auth = inject(AuthService);

  routes = new Map([
    ['listings', 'Listings'],
    ['manage-listings', 'Your listings'],
    ['profile', 'Profile'],
  ]);

  isAuthenticated = this.#auth.isAuthenticated;

  onLogout() {
    this.#auth.logout();
  }
}
