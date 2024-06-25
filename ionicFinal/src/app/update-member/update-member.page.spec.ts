import { ComponentFixture, TestBed } from '@angular/core/testing';
import { UpdateMemberPage } from './update-member.page';

describe('UpdateMemberPage', () => {
  let component: UpdateMemberPage;
  let fixture: ComponentFixture<UpdateMemberPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(UpdateMemberPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
