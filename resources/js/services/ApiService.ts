import axios, { AxiosInstance, AxiosRequestConfig } from 'axios';

class ApiHttp {
  private client: AxiosInstance;

  constructor() {
    this.client = axios.create();
    const csrfToken = document.head.querySelector<HTMLMetaElement>('meta[name="csrf-token"]');
    if (csrfToken != null) {
      this.client.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
    }
  }

  public get(url: string, config?: AxiosRequestConfig) {
    return this.client.get(url, config);
  }
  public post(url: string, data?: any, config?: AxiosRequestConfig) {
    return this.client.post(url, data, config);
  }
  public patch(url: string, data?: any, config?: AxiosRequestConfig) {
    return this.client.patch(url, data, config);
  }
  public delete(url: string, config?: AxiosRequestConfig) {
    return this.client.delete(url, config);
  }
}

const http = new ApiHttp();

export default http;
