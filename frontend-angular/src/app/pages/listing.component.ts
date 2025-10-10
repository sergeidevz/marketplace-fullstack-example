import { Component, inject, signal } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-listing',
  imports: [],
  providers: [],
  styles: ``,
  template: `
    <h1>ID: {{ listingId() }}</h1>
    <div>Just a listing page</div>
  `,
})
export class ListingComponent {
  #activatedRoute = inject(ActivatedRoute);

  listingId = signal('');

  // TODO: Fetch the listing from an API
  constructor() {
    this.#activatedRoute.params.subscribe((params) => {
      this.listingId.set(params['id']);
    });
  }
}
