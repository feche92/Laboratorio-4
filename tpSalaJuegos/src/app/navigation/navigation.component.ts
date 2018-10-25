import { Component } from '@angular/core';
import { BreakpointObserver, Breakpoints, BreakpointState } from '@angular/cdk/layout';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import {JwtHelperService} from "@auth0/angular-jwt";
import { JuegosService } from '../servicios/juegos.service';

@Component({
  selector: 'app-navigation',
  templateUrl: './navigation.component.html',
  styleUrls: ['./navigation.component.css']
})
export class NavigationComponent {
  helper=new JwtHelperService();
  token;
  isHandset$: Observable<boolean> = this.breakpointObserver.observe(Breakpoints.Handset)
    .pipe(
      map(result => result.matches)
    );
    
  constructor(private breakpointObserver: BreakpointObserver,private data:JuegosService,private ruta:Router) {
    this.token=this.helper.decodeToken(localStorage.getItem('token'));
    console.log(this.token.tipo);
    this.data.AgregarHistorial(this.data.token.idCliente).subscribe(
      data=> {
          console.log(data);
      },error=>{
          console.log(error);
    });
  }

  cerrarSesion() {
    localStorage.removeItem('token');
    this.ruta.navigate(['/login']);
    //window.location.reload();
  }

  }
