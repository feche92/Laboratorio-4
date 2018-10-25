import { Juego } from '../clases/juego'
export class JuegoAgilidad extends Juego {
    numero1:number;
    numero2:number;
    operador:any;
    resultado:number;
    constructor(nombre: string, jugador:string) {
        super(nombre,jugador);
    }
    Verificar(respuesta:number){
        if (this.resultado == respuesta) {
            super.Gano();
        }
        else {
            super.Perdio();
        }
        return super.GetGano();
    }
    NuevoJuego(){
        this.numero1 = this.ObtenerNumero();
        this.numero2 = this.ObtenerNumero();
        this.ObtenerOperador();
        super.NuevoJuego();
    }

    public JuegoEmpezado() {
        return super.JuegoEmpezado();
    }

    ObtenerNumero(){
        return Math.floor((Math.random() * 100) + 1);
    }
    ObtenerOperador(){
        let opcion:number = Math.floor((Math.random() * 2) + 1);
        switch (opcion) {
            case 1:
                this.operador = "+";
                this.resultado = this.numero1 + this.numero2;
                break;
            case 2:
                this.operador = "-";
                this.resultado = this.numero1 - this.numero2;
                break;
           /* case 3:
                this.operador = "*";
                this.resultado = this.numero1 * this.numero2;
                break;
            case 4:
                this.operador = "/";
                this.resultado = this.numero1 / this.numero2;
                break;*/
        }
    }
}