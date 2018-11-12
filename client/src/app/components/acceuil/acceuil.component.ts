import { Component, OnInit } from '@angular/core';
import { VoitureService } from '../../../services/voiture.service';

@Component({
  selector: 'app-acceuil',
  templateUrl: './acceuil.component.html',
  styleUrls: ['./acceuil.component.css']
})
export class AcceuilComponent implements OnInit {
  errorMessage: string;
  isoading: boolean = true;

  constructor( private voitureService:VoitureService) {}

  ngOnInit() {
  }
  
}
