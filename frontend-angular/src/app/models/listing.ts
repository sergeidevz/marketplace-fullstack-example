export interface Listing {
  id: string;
  title: string;
  category: string;
  description: string;
  price: number;
  currency: string;
  location: string;
  createdAt: string;
  updatedAt: string;
  user: string; // id vs User
  status: string;
}
