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
  `,
  template: `
    @let isAuth = isAuthenticated();

    <span class="logo">Marketplace</span>
    @if (isAuth) {
      <button (click)="onLogout()">Logout</button>
    } @else {
      <button routerLink="/login">Login</button>
    }
  `,
})
export class HeaderComponent {
  #auth = inject(AuthService);

  isAuthenticated = this.#auth.isAuthenticated;

  onLogout() {
    this.#auth.logout();
  }
}
