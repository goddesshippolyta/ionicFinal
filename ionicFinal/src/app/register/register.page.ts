import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ApiService } from 'src/api.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {
  username: string = '';
  password: string = '';
  email: string = '';
  name: string = '';

  constructor(
    private _apiService: ApiService,
    private router: Router
  ) { }

  ngOnInit(): void {
    // Başlangıç verilerini burada ayarlayabiliriz.
    this.initializeForm();
  }

  initializeForm(): void {
    // Form verilerini sıfırlayabilir veya varsayılan değerler atayabiliriz.
    this.username = '';
    this.password = '';
    this.email = '';
    this.name = '';
  }

  register(): void {
    const userData = {
      username: this.username,
      password: this.password,
      email: this.email,
      name: this.name
    };

    this._apiService.register(userData).subscribe(
      (res: any) => {
        if (res && res.status === 'Success') {
          console.log('User registered successfully');
          // Kayıt başarılı, giriş sayfasına yönlendir
          this.router.navigateByUrl('/login');
        } else {
          // Hata durumunu ele al
          console.error('Registration failed:', res.message);
        }
      },
      (error: any) => {
        console.error('Error:', error);
      }
    );

  }
  goToLogin(): void {
    this.router.navigate(['/login']);
  }
}
