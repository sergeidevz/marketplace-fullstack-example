import { Component, inject } from '@angular/core';
import { AuthService } from '../service-singletons/auth.service';

@Component({
  selector: 'app-page-login',
  styles: `
    :host {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 80vh;
    }

    form {
      padding: 20px;
      background: teal;
    }
  `,
  template: `
    <form>
      <button type="button" (click)="onLogin()">Login</button>
    </form>
  `,
})
export class LoginComponent {
  #auth = inject(AuthService);

  onLogin() {
    this.#auth.login();
  }
}
