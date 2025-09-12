import { HttpClient } from '@angular/common/http';
import { Component, DestroyRef, inject, OnInit, signal } from '@angular/core';
import { environment } from '../environments/environment.development';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';

@Component({
  selector: 'app-root',
  imports: [],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent implements OnInit {
  title = 'frontend-angular';

  api = inject(HttpClient)
  #dRef = inject(DestroyRef)

  status = signal("disabled")

  ngOnInit(): void {
    this.getStatus()
  }

  getStatus() {
    this.api.get<{ status: string }>(environment.API_URL + "/listing")
      .pipe(takeUntilDestroyed(this.#dRef))
      .subscribe(status => {
        this.status.set(status.status)
      })
  }
}
