import { TestBed, inject } from '@angular/core/testing';

import { JuegosService } from './juegos.service';

describe('JuegosService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [JuegosService]
    });
  });

  it('should be created', inject([JuegosService], (service: JuegosService) => {
    expect(service).toBeTruthy();
  }));
});
