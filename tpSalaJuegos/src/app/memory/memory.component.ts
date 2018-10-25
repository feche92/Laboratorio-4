import { Component, OnInit } from '@angular/core';
import { JuegoMemoria } from '../clases/memoria';
import { JuegosService } from '../servicios/juegos.service';

@Component({
  selector: 'app-memory',
  templateUrl: './memory.component.html',
  styleUrls: ['./memory.component.css']
})
export class MemoryComponent implements OnInit {
  tiempo:number;
  ocultar:boolean;
  repetidor:any;
  fotos:boolean;
  miJuego:JuegoMemoria;
  mensaje:string;
  constructor(private data:JuegosService) { }

  ngOnInit() {
    this.ocultar=true;
    this.fotos=false;
    this.tiempo=8;
    this.miJuego=new JuegoMemoria('juegoMemoria',this.data.jugador,this.data);
    this.mensaje='';
  }

  nuevoJuego() {
    this.miJuego=new JuegoMemoria('juegoMemoria',this.data.jugador,this.data);
    this.ocultar=true;
    this.miJuego.NuevoJuego();
    let numRandom:number = Math.floor((Math.random() * 8)) + 1;  
    this.fotos=true;
    this.tiempo=8;
    this.mensaje='';
    this.repetidor = setInterval(()=>{ 
      
      this.tiempo--;
      if(this.tiempo==0 ) {
        //this.GuardarJugada()
        clearInterval(this.repetidor);
        
        this.tiempo=8;
        this.mensaje="Cual es el nombre del animal de la foto "+numRandom+"?";
        this.miJuego.nombreAnimal=this.miJuego.animales[numRandom-1]['nombreAnimal'];
        this.fotos=false;
      }
      }, 900);
  }

  verificar() {
    if(this.miJuego.Verificar()) {
      this.mensaje="Felicidades!! ganaste";
      this.data.GuardarPartida(this.data.token.idCliente,'victorias','memoria').subscribe(
        data=> {
            console.log(data);
        },error=>{
            console.log(error);
    });
    }
    else {
      this.mensaje="Te equivocaste!! el animal es el "+this.miJuego.nombreAnimal;
      this.data.GuardarPartida(this.data.token.idCliente,'derrotas','memoria').subscribe(
        data=> {
            console.log(data);
        },error=>{
            console.log(error);
    });
    }
    this.ocultar = false;
  }

}
