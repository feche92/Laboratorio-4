export abstract class Juego {
    private nombre = 'Sin Nombre';
    private jugador: string;
    private gano:boolean=false;
    private nuevoJuego:boolean=false;
  
    constructor(nombre: string,jugador:string) {
        this.nombre=nombre;
        this.jugador=jugador;
    }

    public Gano() {
        this.gano=true;
    }

    public Perdio() {
        this.gano=false;
    }

    public NuevoJuego() {
        this.nuevoJuego=true;
        this.gano=false;
    }

    public JuegoEmpezado():Boolean {
        return this.nuevoJuego;
    }

    public JuegoTerminado() {
        this.nuevoJuego=false;
    }

    public GetGano():boolean {
        return this.gano;
    }
    
  }