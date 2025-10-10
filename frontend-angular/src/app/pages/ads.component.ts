import { Component, signal } from '@angular/core';
import { Listing } from '../models/listing';

@Component({
  selector: 'app-page-ads',
  styles: `
    .list-item {
      background: teal;
      padding: 5px;
      display: flex;
      justify-content: space-between;
      gap: 20px;
      color: white;
    }

    .list {
      display: flex;
      flex-direction: column;
      gap: 10px;
      width: 20rem;
    }
  `,
  template: `
    <h1>Ads page</h1>

    <ul class="list">
      @for (listing of listings(); track listing.id) {
        <li class="list-item">
          <span>{{ listing.title.toUpperCase() }}</span>
          <span>{{ listing.category }}</span>
          <span>{{ listing.price }} {{ listing.currency }}</span>
        </li>
      }
    </ul>
  `,
})
export class AdsComponent {
  // TEST: test data
  listings = signal<Listing[]>([
    {
      title: 'Bicycle BMX',
      id: '123',
      category: 'Bicycles',
      currency: 'eur',
      description: 'Well used bike for kids',
      location: 'Funchal',
      price: 50,
      status: 'active',
      updatedAt: new Date().toISOString(),
      createdAt: new Date().toISOString(),
      user: '123',
    },
    {
      title: 'Piano',
      id: '1234',
      category: 'Music instruments',
      currency: 'eur',
      description: 'Well used bike for kids',
      location: 'Funchal',
      price: 50,
      status: 'active',
      updatedAt: new Date().toISOString(),
      createdAt: new Date().toISOString(),
      user: '123',
    },
  ]);
}
