import { Component } from '@angular/core';

@Component({
  selector: 'app-page-welcome',
  styles: ``,
  template: `
    <h1>Welcome to the {{ title }}</h1>
  `,
})
export class WelcomeComponent {
  title = 'Marketplace';
}
