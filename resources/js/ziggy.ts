import { Ziggy } from './ziggy';
declare global {
  interface Window {
    Ziggy: any;
  }
}
window.Ziggy = Ziggy;