import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { NavigationComponent } from './navigation/navigation.component';
import { LayoutModule } from '@angular/cdk/layout';
import { ReactiveFormsModule } from '@angular/forms';
import { MatToolbarModule, MatButtonModule, MatSidenavModule, MatIconModule, MatListModule, MatFormFieldModule, MatInputModule, MatSelectModule, MatNativeDateModule } from '@angular/material';
import { MatRadioModule } from '@angular/material/radio';
import { HttpClientModule } from '@angular/common/http';
import { DataService } from './servicios/data.service';
import { FormsModule } from '@angular/forms';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { RuteoModule } from './modulos/ruteo/ruteo.module';
import { TokenService } from './servicios/token.service';
import { EstadisticasComponent } from './estadisticas/estadisticas.component';
import { AnagramaComponent } from './anagrama/anagrama.component';
import { AgilidadComponent } from './agilidad/agilidad.component';
import { AdivinaComponent } from './adivina/adivina.component';
import { MemoryComponent } from './memory/memory.component';

@NgModule({
  declarations: [
    AppComponent,
    NavigationComponent,
    LoginComponent,
    RegisterComponent,
    EstadisticasComponent,
    AnagramaComponent,
    AgilidadComponent,
    AdivinaComponent,
    MemoryComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    NgbModule.forRoot(),
    LayoutModule,
    MatToolbarModule,
    MatButtonModule,
    MatSidenavModule,
    MatIconModule,
    MatListModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    MatNativeDateModule,
    MatRadioModule,
    ReactiveFormsModule,
    FormsModule,
    HttpClientModule,
    RuteoModule
  ],
  providers: [DataService,TokenService],
  bootstrap: [AppComponent]
})
export class AppModule { }
