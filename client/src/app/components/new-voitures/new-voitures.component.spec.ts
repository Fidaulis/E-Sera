import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NewVoituresComponent } from './new-voitures.component';

describe('NewVoituresComponent', () => {
  let component: NewVoituresComponent;
  let fixture: ComponentFixture<NewVoituresComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NewVoituresComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NewVoituresComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
