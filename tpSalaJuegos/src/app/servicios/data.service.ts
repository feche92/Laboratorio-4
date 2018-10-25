import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';

const config={

  headers:new HttpHeaders({
    'Content-Type':'application/x-www-form-urlencoded'
  })
 }

@Injectable({
  providedIn: 'root'
})
export class DataService {
  email;
  clave;
  nombre;
  apellido;
  constructor(private Http:HttpClient) { }

  registrar() {
    let params = 'email='+this.email+'&clave='+this.clave+'&tipo=jugador&nombre='+this.nombre+'&apellido='+this.apellido;
    return this.Http.post('https://lab4ivagaza.000webhostapp.com/api/usuarios/', params,config);
  }

  login() {
    let params = 'email='+this.email+'&clave='+this.clave;
    return this.Http.post('https://lab4ivagaza.000webhostapp.com/api/login/', params,config);
  }
}
