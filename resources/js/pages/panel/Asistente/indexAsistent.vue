<template>
  <Head title="Asistente" />
  <AppLayout>
    <div class="p-4 grid grid-cols-12 gap-4 h-full">
      <!-- Columna izquierda: Chat -->
      <div class="col-span-12 lg:col-span-8 flex flex-col h-[70vh]">
        <h2 class="text-2xl font-bold mb-4">Asistente IA</h2>

        <!-- Zona de mensajes -->
        <div class="flex-1 border rounded-lg p-3 overflow-y-auto bg-surface-100">
          <div v-for="(msg, i) in messages" :key="i" class="mb-3">
            <!-- Mensaje de texto normal -->
            <div
              v-if="msg.type === 'text'"
              :class="[
                'inline-block px-3 py-2 rounded-lg max-w-full',
                msg.from === 'user'
                  ? 'bg-primary text-white ml-auto'
                  : 'bg-surface-0 text-gray-900'
              ]"
            >
              {{ msg.text }}
            </div>

            <!-- Mensaje con listado de talleres -->
            <div
              v-else-if="msg.type === 'talleres'"
              class="bg-surface-0 text-gray-900 rounded-lg p-3"
            >
              <p class="font-semibold mb-2">{{ msg.text }}</p>
              <div
                v-if="msg.talleres.length"
                class="space-y-2 max-h-64 overflow-y-auto"
              >
                <div
                  v-for="t in msg.talleres"
                  :key="t.id"
                  class="border rounded p-2 flex flex-col gap-1"
                >
                  <div class="flex justify-between items-center">
                    <span class="font-semibold text-sm">
                      {{ t.nombre }}
                    </span>
                    <span class="text-xs px-2 py-1 rounded-full bg-primary/10 text-primary">
                      {{ t.turno }}
                    </span>
                  </div>
                  <p class="text-xs text-gray-500">
                    {{ t.fecha_inicio }} al {{ t.fecha_fin }}
                  </p>
                  <p class="text-xs text-gray-500">
                    Cupos: {{ t.cupos_disponibles ?? '—' }} · Estado: {{ t.estado ?? '—' }}
                  </p>
                    <div class="flex justify-end mt-1">
                    <Button
                        label="Inscribirme"
                        icon="pi pi-check"
                        @click="inscribirmeEnTaller(t.id)"
                    />
                    </div>

                </div>
              </div>
              <p v-else class="text-sm text-gray-500">
                No hay talleres para hoy.
              </p>
            </div>

            <!-- Mensaje con listado de alertas -->
            <div
              v-else-if="msg.type === 'alertas'"
              class="bg-surface-0 text-gray-900 rounded-lg p-3"
            >
              <p class="font-semibold mb-2">{{ msg.text }}</p>
              <div
                v-if="msg.alertas.length"
                class="space-y-2 max-h-64 overflow-y-auto"
              >
                <div
                  v-for="a in msg.alertas"
                  :key="a.id"
                  class="border-l-4 border-yellow-500 bg-yellow-50 rounded p-2"
                >
                  <p class="font-semibold text-sm">{{ a.titulo }}</p>
                  <p class="text-xs text-gray-700">{{ a.descripcion }}</p>
                  <p class="text-[11px] text-gray-500 mt-1">
                    Fecha: {{ a.fecha }}
                  </p>
                </div>
              </div>
              <p v-else class="text-sm text-gray-500">
                No hay alertas para hoy.
              </p>
            </div>
          </div>
        </div>

        <!-- Input / acciones rápidas -->
        <div class="mt-3">
          <div class="flex gap-2 mb-2">
            <Button
              label="Talleres de hoy"
              size="small"
              @click="sendQuick('talleres_hoy')"
            />
            <Button
              label="Alertas activas"
              size="small"
              @click="sendQuick('alertas_activas')"
            />
            <Button
              label="Mis horarios"
              size="small"
              @click="sendQuick('mis_horarios')"
            />
          </div>
          <div class="flex gap-2">
            <InputText
              v-model="input"
              placeholder="Escribe tu consulta (ej: ¿Cómo me inscribo a un taller?)"
              class="flex-1"
              @keyup.enter="sendMessage"
            />
            <Button icon="pi pi-send" @click="sendMessage" />
          </div>
        </div>
      </div>

      <!-- Columna derecha: contexto -->
      <div class="col-span-12 lg:col-span-4 space-y-4">
        <div class="border rounded-lg p-4">
          <h3 class="font-semibold mb-2">Atajos útiles</h3>
          <ul class="text-sm space-y-1">
            <li>- Ver talleres de hoy</li>
            <li>- Ver alertas activas</li>
            <li>- Inscribirme a un taller disponible</li>
          </ul>
        </div>

        <div class="border rounded-lg p-4">
          <h3 class="font-semibold mb-2">Resumen de hoy</h3>
          <p class="text-sm">Talleres de hoy: {{ resumen.talleresHoy }}</p>
          <p class="text-sm">Alertas de hoy: {{ resumen.alertasHoy }}</p>
          <p class="text-sm">Próximo horario: {{ resumen.proximoHorario }}</p>
        </div>

        <div class="border rounded-lg p-4">
          <h3 class="font-semibold mb-2">Preguntas frecuentes</h3>
          <ul class="text-sm space-y-1">
            <li
              @click="askFaq('inscribirme_taller')"
              class="cursor-pointer text-primary hover:underline"
            >
              ¿Cómo me inscribo a un taller?
            </li>
            <li
              @click="askFaq('ver_alertas')"
              class="cursor-pointer text-primary hover:underline"
            >
              ¿Cómo veo las alertas del día?
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import AppLayout from '@/layout/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

/** Tipos básicos **/
interface Taller {
  id: number;
  nombre: string;
  turno: string;
  fecha_inicio: string;
  fecha_fin: string;
  capacidad_alumnos: number;
  estado?: string;
  cupos_disponibles?: number;
}

interface Alert {
  id: number;
  titulo: string;
  descripcion: string;
  fecha: string;
}

type ChatMessage =
  | { from: 'user' | 'bot'; type: 'text'; text: string }
  | { from: 'bot'; type: 'talleres'; text: string; talleres: Taller[] }
  | { from: 'bot'; type: 'alertas'; text: string; alertas: Alert[] };

const messages = ref<ChatMessage[]>([
  { from: 'bot', type: 'text', text: 'Hola, soy tu asistente. ¿En qué te ayudo hoy?' },
]);

const input = ref('');

const resumen = ref({
  talleresHoy: 0,
  alertasHoy: 0,
  proximoHorario: '—',
});

/** Utils **/
function hoyISO(): string {
  const d = new Date();
  const y = d.getFullYear();
  const m = String(d.getMonth() + 1).padStart(2, '0');
  const day = String(d.getDate()).padStart(2, '0');
  return `${y}-${m}-${day}`;
}

function dentroDeRangoHoy(t: Taller): boolean {
  try {
    const hoy = new Date(hoyISO());
    const fi = new Date(t.fecha_inicio);
    const ff = new Date(t.fecha_fin);
    return fi <= hoy && hoy <= ff;
  } catch {
    return false;
  }
}

/** Cargar resumen al entrar **/
onMounted(async () => {
  await cargarResumen();
});

/** Enviar mensaje libre (texto plano por ahora) **/
function sendMessage() {
  if (!input.value.trim()) return;
  messages.value.push({ from: 'user', type: 'text', text: input.value });

  // Aquí podrías rutear por palabras clave o mandar a una IA
  messages.value.push({
    from: 'bot',
    type: 'text',
    text: 'Por ahora respondo acciones rápidas: Talleres de hoy, Alertas activas e inscripciones.',
  });

  input.value = '';
}

/** Botones rápidos **/
async function sendQuick(tipo: string) {
  if (tipo === 'talleres_hoy') {
    messages.value.push({
      from: 'user',
      type: 'text',
      text: 'Quiero ver los talleres de hoy',
    });
    await cargarTalleresHoy();
  } else if (tipo === 'alertas_activas') {
    messages.value.push({
      from: 'user',
      type: 'text',
      text: 'Quiero ver las alertas activas de hoy',
    });
    await cargarAlertasHoy();
  } else if (tipo === 'mis_horarios') {
    messages.value.push({
      from: 'user',
      type: 'text',
      text: 'Quiero ver mis horarios',
    });
    messages.value.push({
      from: 'bot',
      type: 'text',
      text: 'La vista de horarios sigue disponible en el menú "Horarios". Pronto la integraré aquí.',
    });
  }
}

/** Preguntas frecuentes -> redirigen a acciones **/
function askFaq(code: string) {
  if (code === 'inscribirme_taller') {
    messages.value.push({
      from: 'bot',
      type: 'text',
      text: 'Para inscribirte, primero veamos los talleres disponibles hoy y luego haz clic en "Inscribirme" en el taller que elijas.',
    });
    sendQuick('talleres_hoy');
  } else if (code === 'ver_alertas') {
    messages.value.push({
      from: 'bot',
      type: 'text',
      text: 'Te muestro las alertas registradas para el día de hoy.',
    });
    sendQuick('alertas_activas');
  }
}

/** Cargar talleres de hoy y mostrarlos en el chat **/
/** Cargar talleres de hoy y mostrarlos en el chat **/
async function cargarTalleresHoy() {
  try {
    // 👇 antes: axios.get('/taller', { params: { per_page: 100 } });
    const res = await axios.get('/asistente/talleres-hoy');
    const lista: Taller[] = res.data.data ?? res.data ?? [];

    // Como el endpoint ya devuelve solo los de hoy, no hace falta volver a filtrar,
    // pero si quieres, puedes mantener el filtro:
    const hoy = lista.filter(dentroDeRangoHoy).slice(0, 10);

    messages.value.push({
      from: 'bot',
      type: 'talleres',
      text: `Estos son los talleres que se dictan hoy (${hoyISO()}):`,
      talleres: hoy,
    });

    resumen.value.talleresHoy = hoy.length;
  } catch (e) {
    console.error(e);
    messages.value.push({
      from: 'bot',
      type: 'text',
      text: 'No pude cargar los talleres de hoy. Inténtalo nuevamente más tarde.',
    });
  }
}


/** Cargar alertas de hoy y mostrarlas en el chat **/
/** Cargar alertas de hoy y mostrarlas en el chat **/
async function cargarAlertasHoy() {
  try {
    const fecha = hoyISO();

    // 👇 ahora usamos el endpoint del asistente
    const res = await axios.get('/asistente/alertas-hoy');
    const lista: Alert[] = res.data.data ?? res.data ?? [];

    messages.value.push({
      from: 'bot',
      type: 'alertas',
      text: `Estas son las alertas registradas para hoy (${fecha}):`,
      alertas: lista,
    });

    resumen.value.alertasHoy = lista.length;
  } catch (e) {
    console.error(e);
    messages.value.push({
      from: 'bot',
      type: 'text',
      text: 'No pude cargar las alertas de hoy. Inténtalo nuevamente más tarde.',
    });
  }
}


/** Inscribirse en un taller usando la ruta /student/inscribirse/{taller} **/
async function inscribirmeEnTaller(tallerId: number) {
  try {
    const res = await axios.post('/inscripciones', {
      taller_id: tallerId,
    });

    if (res.data?.state) {
      toast.add({
        severity: 'success',
        summary: 'Inscripción exitosa',
        detail: res.data.message || 'Te has inscrito correctamente en el taller.',
        life: 4000,
      });

      // 👇 vuelve a cargar resumen (vuelve a llamar a cargarTalleresHoy y cargarAlertasHoy)
      await cargarResumen();
    } else {
      toast.add({
        severity: 'warn',
        summary: 'Advertencia',
        detail: res.data.message || 'No se pudo completar la inscripción.',
        life: 4000,
      });
    }
  } catch (error: any) {
    const msg =
      error?.response?.data?.message ??
      'No se pudo completar la inscripción. Verifica que tengas permisos o que el taller tenga cupos.';
    toast.add({
      severity: 'error',
      summary: 'Error de inscripción',
      detail: msg,
      life: 5000,
    });
    console.error('Error al inscribirse:', error);
  }
}



/** Cargar resumen rápido (talleres + alertas de hoy) **/
async function cargarResumen() {
  try {
    const [_, __] = await Promise.all([cargarTalleresHoy(), cargarAlertasHoy()]);
    // Podrías llamar también a /horario para calcular el próximo horario
    resumen.value.proximoHorario = 'Revisa la sección Horarios para más detalle.';
  } catch {
    // ya se manejan errores en cada función
  }
}
</script>
