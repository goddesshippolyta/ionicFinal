import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ApiService } from 'src/api.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  username: string = '';
  password: string = '';

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
  }

  login(): void {
    const userCredentials = {
      username: this.username,
      password: this.password
    };

    console.log('User Credentials:', userCredentials); // Giriş verilerini kontrol et

    this._apiService.login(userCredentials).subscribe(
      (res: any) => {
        console.log('User Response:', res);
        if (res && res.status === 'Success') {
          const user = res.user;
          console.log('User Data:', user.username, user.email, user.name);
          // Giriş başarılı, anasayfaya yönlendirin
          this.router.navigateByUrl('/home');
        } else {
          // Hata durumunu ele al
          console.error('Login failed:', res.message);
        }
      },
      (error: any) => {
        console.log('Error:', error);
      }
    );
  }
  goToRegister(): void {
    this.router.navigate(['/register']);
  }
}
