import { Component, OnInit } from '@angular/core';
import { DataService } from '../servicios/data.service';
import { Router } from '@angular/router';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
  loginForm: FormGroup;
  constructor(private data:DataService,private ruta:Router,private fb: FormBuilder) {
    this.buildForm();
   }

   buildForm() {
    this.loginForm = this.fb.group({
    email: ['', Validators.compose([Validators.required, Validators.email]) ],
    password: ['', Validators.compose([Validators.required, Validators.minLength(4)]) ],
    nombre: ['', Validators.compose([Validators.required, Validators.minLength(3)]) ],
    apellido: ['', Validators.compose([Validators.required, Validators.minLength(3)]) ],
    });
  }

  registrar() {
    this.data.email=this.loginForm.get('email').value;
    this.data.clave=this.loginForm.get('password').value;
    this.data.nombre=this.loginForm.get('nombre').value;
    this.data.apellido=this.loginForm.get('apellido').value;
    this.data.registrar().subscribe(
      data=> {
        console.log(data);
        alert(data['message']);
        this.ruta.navigate(['/login']);
      },error=>{
        console.log(error);
    });
  }

  ngOnInit() {
  }

}
