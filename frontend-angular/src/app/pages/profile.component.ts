import { Component, inject } from '@angular/core';
import { AuthService } from '../service-singletons/auth.service';

@Component({
  selector: 'app-page-profile',
  styles: ``,
  template: `
    @let usr = user();

    <h1>Profile page</h1>

    @if (usr) {
      <div>{{ usr.firstName }}</div>
      <div>{{ usr.lastName }}</div>
      <div>{{ usr.bio }}</div>
      <div>{{ usr.email }}</div>
    } @else {
      <div>You are logged out</div>
    }
  `,
})
export class ProfileComponent {
  #auth = inject(AuthService);

  user = this.#auth.user;
}
