import { Component, OnInit } from '@angular/core';
import { JuegosService } from '../servicios/juegos.service';

@Component({
  selector: 'app-estadisticas',
  templateUrl: './estadisticas.component.html',
  styleUrls: ['./estadisticas.component.css']
})
export class EstadisticasComponent implements OnInit {
  jugador;
  datosJugador;
  datosJuegos;
  bandera:boolean=true;
  constructor(private data:JuegosService) {
    this.jugador=this.data.jugador;
    this.data.DatosJugador(this.data.token.idCliente).subscribe(
      data=> {
          console.log(data);
          this.datosJugador=data;
      },error=>{
          console.log(error);
    });
    this.data.DatosJuegos().subscribe(
      data=> {
          console.log(data);
          this.datosJuegos=data;
      },error=>{
          console.log(error);
    });
  }

  ngOnInit() {
  }

}
