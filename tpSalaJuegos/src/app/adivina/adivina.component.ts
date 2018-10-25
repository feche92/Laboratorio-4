import { Component, OnInit } from '@angular/core';
import { JuegoAdivina } from '../clases/adivina';
import { JuegosService } from '../servicios/juegos.service';

@Component({
  selector: 'app-adivina',
  templateUrl: './adivina.component.html',
  styleUrls: ['./adivina.component.css']
})
export class AdivinaComponent implements OnInit {
  miJuego:JuegoAdivina;
  ocultar:boolean;
  intentos:number;
  mensaje:string;
  ayuda:string;
  constructor(private data:JuegosService) { }

  ngOnInit() {
    this.ocultar=true;
    this.miJuego=new JuegoAdivina('adivinaNumero',this.data.jugador);
  }

  nuevoJuego() {
    this.ocultar=true;
    this.miJuego.NuevoJuego();
    this.intentos=5;
    this.mensaje="";
    this.ayuda='';
  }

  verificar() {
    this.intentos--;
    if(this.miJuego.verificar()) {
      this.mensaje='Felicidades!! ganaste en '+(5-this.intentos)+' intentos';
      this.ocultar=false;
      this.data.GuardarPartida(this.data.token.idCliente,'victorias','adivina').subscribe(
        data=> {
            console.log(data);
        },error=>{
            console.log(error);
    });
    }
    else {
      if(this.intentos==0) {
        this.mensaje='Lo siento, se te acabaron los intentos, el numero secreto es: ' + this.miJuego.numeroSecreto;
        this.ocultar=false;
        this.data.GuardarPartida(this.data.token.idCliente,'derrotas','adivina').subscribe(
          data=> {
              console.log(data);
          },error=>{
              console.log(error);
      });
      }
      else {
        this.ayuda=this.miJuego.retornarAyuda();
      }
    }
  }

}
