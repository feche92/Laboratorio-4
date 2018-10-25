import { Component, OnInit } from '@angular/core';
import { JuegoAnagrama } from '../clases/anagrama';
import { JuegosService } from '../servicios/juegos.service';

@Component({
  selector: 'app-anagrama',
  templateUrl: './anagrama.component.html',
  styleUrls: ['./anagrama.component.css']
})
export class AnagramaComponent implements OnInit {
  jugador:string;
  ocultar:boolean;
  miJuego:JuegoAnagrama;
  respuesta:string;
  mensaje:string;
  constructor(private data:JuegosService) {
    this.jugador=this.data.jugador;
    console.log(this.jugador);
   }

  ngOnInit() {
    this.ocultar = true;
    this.miJuego=new JuegoAnagrama('anagrama','normal',this.jugador,this.data);
  }

  nuevoJuego() {
    console.log(this.miJuego.nivel);
    this.miJuego=new JuegoAnagrama('anagrama',this.miJuego.nivel,this.jugador,this.data);
    this.miJuego.NuevoJuego();
    this.ocultar = true;
    this.respuesta = "";
    this.mensaje="";
  }

  verificar() {
    if(this.miJuego.Verificar(this.respuesta)) {
      console.log('gano');
      this.mensaje="Felicidades Usted Gano!"
      this.data.GuardarPartida(this.data.token.idCliente,'victorias','anagrama').subscribe(
        data=> {
            console.log(data);
        },error=>{
            console.log(error);
    });
    }
    else {
      console.log('perdio');
      this.mensaje="Usted Perdio! La Palabra era: "+this.miJuego.palabraSecreta;
      this.data.GuardarPartida(this.data.token.idCliente,'derrotas','anagrama').subscribe(
        data=> {
            console.log(data);
        },error=>{
            console.log(error);
    });
    }
    this.ocultar = false;
  }

}
