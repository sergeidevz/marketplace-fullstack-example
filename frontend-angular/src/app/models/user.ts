export interface User {
  id: string;
  email: string;
  roles: string[];
  firstName: string;
  lastName: string;
  displayName?: string;
  bio: string;
  avatar?: string;
  phone?: string;
  location: string;
  language: string;
  createdAt: string;
  updatedAt?: string | null;
}
