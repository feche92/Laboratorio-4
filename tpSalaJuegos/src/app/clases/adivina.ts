import { Juego } from '../clases/juego'
/**
 * Juego adivina el Numero
 * la amquina genera un numero secreto ramdom entre 0 y 100.
 * El jugador debe adivinar el numero.
 * la maquina le informa si el numero ingresado es mayor o menor al numero secreto.
 */
export class JuegoAdivina extends  Juego {
    numeroSecreto: number = 0;
    numeroIngresado = 0;
    constructor(nombre: string, jugador:string) {
        super(nombre,jugador);
     
    
      
      }
    public verificar() {
        if (this.numeroIngresado == this.numeroSecreto) {
          super.Gano();
        }
        return super.GetGano();
     }

     public NuevoJuego() {
        this.generarnumero();
        super.NuevoJuego();
     }

     public JuegoEmpezado() {
        return super.JuegoEmpezado();
    }

     public generarnumero() {
        this.numeroSecreto = Math.floor((Math.random() * 100) + 1);
        this.numeroIngresado=null;
        console.info('numero Secreto:' + this.numeroSecreto);
      }
      public retornarAyuda() {
        if (this.numeroIngresado < this.numeroSecreto) {
          return "Falta";
        }
        return "Te pasate";
      }
}