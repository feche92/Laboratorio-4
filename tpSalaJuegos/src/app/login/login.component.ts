import { Component, OnInit } from '@angular/core';
import { DataService } from '../servicios/data.service';
import { Router } from '@angular/router';
import {Title} from '@angular/platform-browser';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  constructor(private data:DataService,private ruta:Router,private fb: FormBuilder,title: Title) {
    this.buildForm();
  }

  buildForm() {
    this.loginForm = this.fb.group({
    email: ['', Validators.compose([Validators.required, Validators.email]) ],
    password: ['', Validators.compose([Validators.required, Validators.minLength(4)]) ],
    });
  }

  ingresar() {
    this.data.email=this.loginForm.get('email').value;
    this.data.clave=this.loginForm.get('password').value;
    this.data.login().subscribe(
      data=> {
        console.log(data);
        if(data['status']=='success') {
          localStorage.setItem('token',data['message']);
          this.ruta.navigate(['/menu/estadisticas']);
        }
        else {
          alert(data['message']);
        }
      },error=>{
        console.log(error);
      });
    
  }

  ngOnInit() {
  }

}