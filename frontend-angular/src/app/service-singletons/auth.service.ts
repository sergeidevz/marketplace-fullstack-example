import { computed, Injectable, signal } from '@angular/core';
import { User } from '../models/user';

@Injectable({ providedIn: 'root' })
export class AuthService {
  user = signal<User | null>(null);
  isAuthenticated = computed(() => !!this.user());

  login() {
    // TEST: Fetch from api instead
    const user: User = {
      id: '1',
      email: 'john.doe@example.com',
      roles: ['user'],
      firstName: 'John',
      lastName: 'Doe',
      displayName: 'John D.',
      bio: 'Enthusiastic seller of vintage motorcycle parts and accessories.',
      avatar: 'https://example.com/avatars/john-doe.jpg',
      phone: '+351912345678',
      location: 'Funchal, Madeira',
      language: 'en',
      createdAt: new Date().toISOString(),
      updatedAt: new Date().toISOString(),
    };

    this.user.set(user);
  }

  logout() {
    this.user.set(null);
  }
}
