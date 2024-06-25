import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ApiService } from 'src/api.service';

@Component({
  selector: 'app-update-member',
  templateUrl: './update-member.page.html',
  styleUrls: ['./update-member.page.scss'],
})
export class UpdateMemberPage implements OnInit {
  year: any;
  memberOne: any;
  memberTwo: any;
  id: any;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private _apiService: ApiService
  ) {}

  ngOnInit() {
    this.route.params.subscribe((param: any) => {
      this.id = param.id;
      console.log('Member ID:', this.id);
      this.getSingleMember(this.id);
    });
  }

  getSingleMember(id: number) {
    this._apiService.getSingleMember(id).subscribe(
      (res: any) => {
        console.log('Single Member Response:', res);
        if (res && res.length) {
          const member = res[0];
          this.year = member.year;
          this.memberOne = member.memberOne;
          this.memberTwo = member.memberTwo;
          console.log('Member Data:', this.year, this.memberOne, this.memberTwo);
        }
      },
      (error: any) => {
        console.log('Error:', error);
      }
    );
  }

  updateMember() {
    const data = {
      year: this.year,
      memberOne: this.memberOne,
      memberTwo: this.memberTwo,
    };

    console.log('Data to Update:', JSON.stringify(data)); // JSON verisini kontrol et

    this._apiService.updateMember(this.id, data).subscribe(
      (res: any) => {
        console.log('Update Response:', res);
        if (res.status === 'Success') {

          this.router.navigateByUrl('/home');
          alert('Updated');
        }
      },
      (error: any) => {
        console.log('Update Error:', error);
      }
    );
  }

}
