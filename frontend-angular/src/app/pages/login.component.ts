import { Component, inject } from '@angular/core';
import { AuthService } from '../service-singletons/auth.service';

@Component({
  selector: 'app-page-login',
  styles: ``,
  template: `
    <button (click)="onLogin()">Login</button>
  `,
})
export class LoginComponent {
  #auth = inject(AuthService);

  onLogin() {
    this.#auth.login();
  }
}
