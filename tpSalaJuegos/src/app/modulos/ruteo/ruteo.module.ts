import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { Routes, RouterModule } from "@angular/router";
import { RegisterComponent } from '../../register/register.component';
import { LoginComponent } from '../../login/login.component';
import { NavigationComponent } from '../../navigation/navigation.component';
import { TokenService } from '../../servicios/token.service';
import { EstadisticasComponent } from '../../estadisticas/estadisticas.component';
import { AnagramaComponent } from '../../anagrama/anagrama.component';
import { AgilidadComponent } from 'src/app/agilidad/agilidad.component';
import { AdivinaComponent } from 'src/app/adivina/adivina.component';
import { MemoryComponent } from 'src/app/memory/memory.component';

const rutas: Routes = [
  { path: '', component: LoginComponent, data: { title: 'First Component' } },
  { path:'login',component:LoginComponent },
  { path:'register',component:RegisterComponent },
  { path:'menu',component:NavigationComponent,canActivate:[TokenService],children:[
    {path:'estadisticas',component:EstadisticasComponent},
    {path:'anagrama',component:AnagramaComponent,canActivate:[TokenService],data: { title: 'First Component' }},
    {path:'agilidad',component:AgilidadComponent,canActivate:[TokenService],data: { title: 'First Component' }},
    {path:'adivina',component:AdivinaComponent,canActivate:[TokenService],data: { title: 'First Component' }},
    {path:'memoria',component:MemoryComponent,canActivate:[TokenService],data: { title: 'First Component' }},
  ]},
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(rutas)
  ],
  exports:[RouterModule],
  declarations: []
})
export class RuteoModule { }
