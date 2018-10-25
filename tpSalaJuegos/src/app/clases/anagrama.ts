import { Juego } from '../clases/juego'
import { JuegosService } from '../servicios/juegos.service';
export class JuegoAnagrama extends Juego{
    public palabraSecreta:string;
    public palabraMezclada:string;
    public nivel:string;
    constructor(nombre: string, nivel: string, jugador:string,private data:JuegosService) {
        super(nombre,jugador);
        this.nivel=nivel;
    }

    public ObtenerPalabra(){
        this.data.ObtenerPalabras(this.nivel).subscribe(
            data=> {
                console.log(data);
                let palabras:any=data;
                let numRandom:number = Math.floor((Math.random() * 18));
                console.log(numRandom);
                this.palabraSecreta = palabras[numRandom]['palabra'];
                this.palabraMezclada = palabras[numRandom]['anagrama'];
            },error=>{
                console.log(error);
        });
        
    }

    public JuegoEmpezado() {
        return super.JuegoEmpezado();
    }
    public NuevoJuego(){
        this.ObtenerPalabra();
        super.NuevoJuego();
    }
    public Verificar(respuesta:string):boolean{
        this.palabraSecreta=this.palabraSecreta.toLowerCase();
        respuesta=respuesta.toLowerCase();
        if (this.palabraSecreta == respuesta) {
            //super.JuegoTerminado();
            super.Gano();
            return true;
        }
        else{
            //super.JuegoTerminado();
            super.Perdio();
            return false;
        }
    }
}