import { Component, OnInit } from '@angular/core';
import {Subscription} from "rxjs";
import {TimerObservable} from "rxjs/observable/TimerObservable";
import { JuegosService } from '../servicios/juegos.service';
import { JuegoAgilidad } from '../clases/agilidad';

@Component({
  selector: 'app-agilidad',
  templateUrl: './agilidad.component.html',
  styleUrls: ['./agilidad.component.css']
})
export class AgilidadComponent implements OnInit {
  miJuego:JuegoAgilidad;
  ocultar:boolean;
  respuesta:number;
  Tiempo: number;
  repetidor:any;
  mensaje:string;
  constructor(private data:JuegosService) { }

  ngOnInit() {
    this.ocultar=true;
    this.miJuego=new JuegoAgilidad('AgilidadAritmetica',this.data.jugador);
    this.Tiempo=15;
  }

  nuevoJuego() {
    this.miJuego.NuevoJuego();
    this.ocultar = true;
    this.respuesta = null;
    this.mensaje="";
    this.repetidor = setInterval(()=>{ 
      
      this.Tiempo--;
      if(this.Tiempo==0 ) {
        //this.GuardarJugada()
        clearInterval(this.repetidor);
        
        this.Tiempo=15;
        this.mensaje='Se te acabo el tiempo mounstro! la respuesta es: '+this.miJuego.resultado;
        this.ocultar = false;
        this.respuesta = null;
        this.data.GuardarPartida(this.data.token.idCliente,'derrotas','AgilidadAritmetica').subscribe(
          data=> {
              console.log(data);
          },error=>{
              console.log(error);
      });
      }
      }, 900);
  }

  verificar() {
    if(this.miJuego.Verificar(this.respuesta)) {
      this.mensaje="Bien hecho";
      this.data.GuardarPartida(this.data.token.idCliente,'victorias','AgilidadAritmetica').subscribe(
        data=> {
            console.log(data);
        },error=>{
            console.log(error);
    });
    }
    else {
      this.mensaje="Te equivocaste! la respuesta es:" +this.miJuego.resultado;
      this.data.GuardarPartida(this.data.token.idCliente,'derrotas','AgilidadAritmetica').subscribe(
        data=> {
            console.log(data);
        },error=>{
            console.log(error);
    });
    }
    clearInterval(this.repetidor);
    this.Tiempo=15;
    this.ocultar = false;
  }

}
