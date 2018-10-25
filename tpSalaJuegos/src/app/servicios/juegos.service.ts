import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import {JwtHelperService} from "@auth0/angular-jwt";

const config={

  headers:new HttpHeaders({
    'Content-Type':'application/x-www-form-urlencoded',
    //token:localStorage.getItem('token')
  })
 }

@Injectable({
  providedIn: 'root'
})
export class JuegosService {
  jugador:string;
  helper=new JwtHelperService();
  token;
  constructor(private Http:HttpClient) {
    this.token=this.helper.decodeToken(localStorage.getItem('token'));
    this.jugador=this.token.email;
   }

  ObtenerPalabras(nivel:string) {
    let params='nivel='+nivel;
    return this.Http.post('https://lab4ivagaza.000webhostapp.com/api/anagrama/',params,config);
  }

  GuardarPartida(id:string,partida:string,juego:string) {
    let params='id='+id+'&partida='+partida+'&juego='+juego;
    return this.Http.post('https://lab4ivagaza.000webhostapp.com/api/partida/',params,config);
  }

  ObtenerAnimales() {
    return this.Http.get('https://lab4ivagaza.000webhostapp.com/api/animales/',config);
  }

  DatosJugador(id) {
    let params='id='+id;
    return this.Http.post('https://lab4ivagaza.000webhostapp.com/api/dataJugador/',params,config);
  }

  DatosJuegos() {
    return this.Http.get('https://lab4ivagaza.000webhostapp.com/api/dataJuegos/',config);
  }

  AgregarHistorial(id) {
    let params='id='+id;
    return this.Http.post('https://lab4ivagaza.000webhostapp.com/api/agregarHistorial/',params,config);
  }
}
