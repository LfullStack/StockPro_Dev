import * as THREE from 'three';// Importar la biblioteca Three.js
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';// Importar los controles de órbita

// Escena y configuración inicial
const scene = new THREE.Scene();


// Obtener el contenedor del logo
const container = document.getElementById('logo3d');// Agregar el ID del contenedor al archivo HTML
const width = container.clientWidth;// Obtener el ancho del contenedor
const height = container.clientHeight;// Obtener la altura del contenedor


// Crear una cámara con un campo de visión de 75 grados, relación de aspecto basada en el tamaño del contenedor, 
// y un rango de visión de 0.1 a 1000
const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
camera.position.set(2, 2, 3);

// Crear un renderizador WebGL con antialiasing y fondo transparente
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setSize(width, height);
renderer.setPixelRatio(window.devicePixelRatio);
container.appendChild(renderer.domElement);

// Controladores de órbita para la cámara
const controls = new OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;// Habilitar amortiguación para un movimiento suave
controls.autoRotate = true;// Habilitar rotación automática
controls.autoRotateSpeed = 1.2;// Velocidad de rotación automática
controls.enablePan = false;// Deshabilitar paneo
controls.enableZoom = false;// Deshabilitar zoom
controls.minPolarAngle = Math.PI / 4;// Ángulo polar mínimo para limitar la rotación vertical
controls.maxPolarAngle = Math.PI * 3 / 4;// Ángulo polar máximo para limitar la rotación vertical

// Función para renderizar la escena
const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);// Crear una luz ambiental con color blanco y intensidad 0.6
scene.add(ambientLight);// Agregar luz ambiental a la escena

const directionalLight = new THREE.DirectionalLight(0xffffff, 1.2);// Crear una luz direccional con color blanco y intensidad 1.2
directionalLight.position.set(5, 10, 7.5);// Establecer la posición de la luz direccional
scene.add(directionalLight);// Agregar luz direccional a la escena

// Grupo para contener los elementos del logo
const logoGroup = new THREE.Group();
scene.add(logoGroup);

// Crea un plano de fondo para el logo
const materials = [
    new THREE.MeshStandardMaterial({ color: 0x718096, roughness: 0.4, metalness: 0.1 }),
    new THREE.MeshStandardMaterial({ color: 0x4A5568, roughness: 0.4, metalness: 0.1 }),
    new THREE.MeshStandardMaterial({ color: 0xFF2D20, roughness: 0.4, metalness: 0.1 }),
]; // Materiales para las barras del gráfico

// Crear las barras del gráfico
const boxSize = 1.2;
const boxHeights = [1.5, 2.5, 3.5];
const spacing = 0.25;

// Pasa por cada altura de caja y crea una caja con la altura correspondiente
boxHeights.forEach((height, i) => {
    const geometry = new THREE.BoxGeometry(boxSize, height, boxSize); // Crear geometría de caja con tamaño definido
    const box = new THREE.Mesh(geometry, materials[i % materials.length]);// Crear malla de caja con geometría y material
    const xPos = (i - (boxHeights.length - 1) / 2) * (boxSize + spacing);// Calcular la posición X de la caja para centrar el gráfico
    box.position.set(xPos, height / 2, 0);// Establecer la posición de la caja
    logoGroup.add(box);// Agregar la caja al grupo del logo
});

// Ubicar el grupo del logo en la escena
logoGroup.position.y = -1.5;

// Función de animación
function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}

// Manejador de eventos para el cambio de tamaño de la ventana
window.addEventListener('resize', onWindowResize, false);


// Función para ajustar la escala de la cámara y el renderizador
function onWindowResize() {
    const newWidth = container.clientWidth;
    const newHeight = container.clientHeight;

    camera.aspect = newWidth / newHeight;
    camera.updateProjectionMatrix();

    renderer.setSize(newWidth, newHeight);
}

// Iniciar la animación
animate();
