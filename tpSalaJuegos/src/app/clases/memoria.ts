import { Juego } from '../clases/juego';
import { JuegosService } from '../servicios/juegos.service';

export class JuegoMemoria extends Juego{ 
    public animales;
    public respuesta:string;
    public nombreAnimal:string;

    constructor(nombre: string, jugador:string, private data:JuegosService) {
        super(nombre,jugador);
        this.animales=new Array();
        this.respuesta='';
        this.nombreAnimal='';
    }

    public ObtenesAnimales() {
        this.data.ObtenerAnimales().subscribe(
            data=> {
                console.log(data);
                let num=0;
                while(num<8)
                {
                    let numRandom:number = Math.floor((Math.random() * 50));
                    console.log(numRandom);
                    if(this.PerteneceAnimal(data[numRandom]['nombreAnimal'])) {
                        this.animales.push(data[numRandom]);
                        num++;
                    }
                }
                console.log(this.animales);
                //this.palabraSecreta = palabras[numRandom]['palabra'];
                //this.palabraMezclada = palabras[numRandom]['anagrama'];
            },error=>{
                console.log(error);
        });
    }

    PerteneceAnimal(nombre:string) {
        for(let i=0;i<this.animales.length;i++)
        {
            if(this.animales[i]['nombreAnimal']==nombre) {
                return false;
            }
        }
        return true;
    }

    NuevoJuego() {
        super.NuevoJuego();
        this.ObtenesAnimales();
    }

    Verificar() {
        if(this.nombreAnimal==this.respuesta) {
            super.Gano();
            return true;
        }
        else {
            super.Perdio();
            return false;
        }

    }

    public JuegoEmpezado() {
        return super.JuegoEmpezado();
    }
}
