import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  private registerApiUrl = 'http://localhost/backend/register.php';
  private loginApiUrl = 'http://localhost/backend/login.php';
  private addApiUrl = 'http://localhost/backend/create.php';
  private getApiUrl = 'http://localhost/backend/getMembers.php';
  private deleteApiUrl = 'http://localhost/backend/delete.php';
  private updateApiUrl = 'http://localhost/backend/updateMember.php';
  private getSingleMemberApiUrl = 'http://localhost/backend/getSingleMember.php';
  private logoutApiUrl = 'http://localhost/backend/logout.php';

  constructor(private http: HttpClient) {}

  register(data: any): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    });
    return this.http.post(this.registerApiUrl, data, { headers });
  }

  login(user_id: any): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    });
    return this.http.post(this.loginApiUrl, user_id, { headers });
  }


  addMember(data: any): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    });
    return this.http.post(this.addApiUrl, data, { headers });
  }

  getMembers(): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    });
    return this.http.get(this.getApiUrl, { headers });
  }

  deleteMember(id: number): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    });
    const url = `${this.deleteApiUrl}?id=${id}`;
    return this.http.delete(url, { headers });
  }
  logout(): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    });

    return this.http.post(this.logoutApiUrl, {}, { headers });
  }
  updateMember(id: number, data: any): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    });
    const url = `${this.updateApiUrl}?id=${id}`;
    return this.http.put(url, data, { headers });
  }

  getSingleMember(id: number): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    });
    const url = `${this.getSingleMemberApiUrl}?id=${id}`;
    return this.http.get(url, { headers });
  }


}

