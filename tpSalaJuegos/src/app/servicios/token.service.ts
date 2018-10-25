import { Injectable, Input } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import {JwtHelperService} from "@auth0/angular-jwt";

@Injectable({
  providedIn: 'root'
})
export class TokenService implements CanActivate {
  helper=new JwtHelperService();
  constructor(private router: Router) {

   }

  canActivate()
  {
     const token = localStorage.getItem('token');
  
      if(!token)
      {
        this.router.navigate(['/login']);
        return false;  
      }
      else
      {
        return true;  
      }
            
      
    }
}
