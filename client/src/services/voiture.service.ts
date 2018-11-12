import { Router } from '@angular/router';


import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../environments/environment';
@Injectable()
export class VoitureService {
    voituresUser: string;
    private _token: string;
    constructor(private http: HttpClient) {
        this.voituresUser = environment.hosts.userVoitures;
    }
    /**
     * Get token of User
     */
    getToken() {
        return this._token;
    }
    /**
     * Get Http Option
     */
    getHTTPOption(options: any = {}) {
        let headers = new HttpHeaders({ Authorization: this._token });
        if (options.json)
            headers.append('Content-Type', 'application/json');
        return {
            headers: headers,
            json: true
        };
    }
    /**
     * Create Voitures collection
     */
    createVoitures(data): Promise<any> {
        const url = this.voituresUser + '/addVoitures';
        return this.http.post(url, data).toPromise();
    }
    /**
     * Lister tous les voitures
     */
    // getVoitures(): Promise<any> {
    //     const url = this.voituresUser + '/getVoitures';
    //     return this.http.get(url).map((res: any) => res).toPromise();
    // }
}