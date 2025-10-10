import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet],
  styles: ``,
  template: `
    <main>
      <router-outlet />
    </main>
  `,
})
export class AppComponent {}
