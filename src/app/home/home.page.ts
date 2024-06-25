import { Component, OnInit } from '@angular/core';
import { ApiService } from 'src/api.service';
import { Router } from '@angular/router';

interface Note {
  id: number;
  year: any;
  memberOne: any;
  memberTwo: any;
}

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage implements OnInit {
  notes: Note[] = [];
  year: any = '';
  memberOne: any = '';
  memberTwo: any = '';

  constructor(private _apiService: ApiService, private router: Router) {}

  ngOnInit() {
    this.getMembers();
  }

  addMember() {
    const newMember = {
      year: this.year,
      memberOne: this.memberOne,
      memberTwo: this.memberTwo
    };
    this._apiService.addMember(newMember).subscribe(
      (res: any) => {
        console.log('SUCCESS ===', res);
        this.getMembers();
      },
      (error: any) => {
        console.log('ERROR ===', error);
      }
    );
  }

  getMembers() {
    this._apiService.getMembers().subscribe(
      (res: Note[]) => {
        this.notes = res;
        console.log('SUCCESS ===', res);
      },
      (error: any) => {
        console.log('ERROR ===', error);
      }
    );
  }

  deleteMember(id: number) {
    this._apiService.deleteMember(id).subscribe(
      (res: any) => {
        console.log('SUCCESS ===', res);
        this.getMembers();
      },
      (error: any) => {
        console.log('ERROR ===', error);
      }
    );
  }

  updateMember(id: number) {
    console.log('UPDATE MEMBER ID ===', id);
    this.router.navigate(['/update-member', id]);
  }
  logout() {
    this._apiService.logout().subscribe(
      (res: any) => {
        console.log('Logout SUCCESS ===', res);
        this.router.navigate(['/login']);
        // Redirect or perform other actions after successful logout
      },
      (error: any) => {
        console.log('Logout ERROR ===', error);
        // Handle error if needed
      }
    );
  }

}
