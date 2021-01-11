import axios, { AxiosInstance, AxiosRequestConfig } from 'axios';

class BookListHttp {
  private client: AxiosInstance;

  constructor() {
    this.client = axios.create();
  }

  public get(url: string, config?: AxiosRequestConfig) {
    return this.client.get(url, config);
  }
  public post(url: string, data?: any, config?: AxiosRequestConfig) {
    return this.client.post(url, data, config);
  }
  public put(url: string, data?: any, config?: AxiosRequestConfig) {
    return this.client.put(url, data, config);
  }
  public patch(url: string, data?: any, config?: AxiosRequestConfig) {
    return this.client.patch(url, data, config);
  }
  public delete(url: string, config?: AxiosRequestConfig) {
    return this.client.delete(url, config);
  }
}

const http = new BookListHttp();

export default http;
