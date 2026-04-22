import React from 'react';
import ReactDOM from 'react-dom/client';
import '../../css/frontend.css';

function App() {
    const stats = window.financeiroFrontend?.stats ?? [];
    const highlights = window.financeiroFrontend?.highlights ?? [];

    return (
        <div className="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.18),_transparent_26%),linear-gradient(135deg,#06131a_0%,#0f2d37_45%,#f4efe7_100%)] text-slate-100">
            <section className="mx-auto flex min-h-screen w-full max-w-7xl flex-col px-6 py-8 lg:px-10">
                <header className="mb-10 flex items-center justify-between rounded-full border border-white/10 bg-white/8 px-5 py-3 backdrop-blur-xl">
                    <div>
                        <span className="text-xs uppercase tracking-[0.3em] text-cyan-200">Financeiro Pro Whats</span>
                    </div>
                    <a
                        href="/admin/dashboard"
                        className="rounded-full border border-cyan-300/40 bg-cyan-300/12 px-4 py-2 text-sm font-semibold text-cyan-50 transition hover:bg-cyan-300/20"
                    >
                        Entrar no painel
                    </a>
                </header>

                <div className="grid flex-1 items-center gap-10 lg:grid-cols-[1.2fr_0.8fr]">
                    <div>
                        <span className="mb-5 inline-flex rounded-full border border-amber-300/30 bg-amber-300/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-amber-100">
                            SaaS multi-tenant premium
                        </span>
                        <h1 className="max-w-4xl text-5xl font-black leading-none tracking-[-0.05em] text-white md:text-7xl">
                            Gestao financeira, cobrancas e WhatsApp com visual moderno e operacao elegante.
                        </h1>
                        <p className="mt-6 max-w-2xl text-lg leading-8 text-slate-200/88">
                            Frontend publico em React com Tailwind 4, backend administrativo em AdminLTE 4
                            e base preparada para demonstracao com tenants, clientes, cobrancas e gateways.
                        </p>

                        <div className="mt-10 grid gap-4 sm:grid-cols-3">
                            {stats.map(item => (
                                <div
                                    key={item.label}
                                    className="rounded-[28px] border border-white/10 bg-white/8 p-5 shadow-[0_24px_80px_rgba(3,7,18,0.28)] backdrop-blur-xl"
                                >
                                    <div className="text-sm uppercase tracking-[0.18em] text-slate-300">{item.label}</div>
                                    <div className="mt-3 text-3xl font-black text-white">{item.value}</div>
                                    <div className="mt-2 text-sm text-slate-300">{item.description}</div>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className="relative">
                        <div className="absolute inset-0 -rotate-3 rounded-[36px] bg-cyan-300/10 blur-3xl" />
                        <div className="relative overflow-hidden rounded-[36px] border border-white/12 bg-slate-950/60 p-6 shadow-[0_30px_120px_rgba(2,8,23,0.55)] backdrop-blur-2xl">
                            <div className="mb-6 flex items-center justify-between">
                                <div>
                                    <div className="text-sm uppercase tracking-[0.22em] text-cyan-200">Preview</div>
                                    <div className="mt-2 text-2xl font-bold text-white">Operacao em tempo real</div>
                                </div>
                                <div className="flex gap-2">
                                    <span className="h-3 w-3 rounded-full bg-emerald-400" />
                                    <span className="h-3 w-3 rounded-full bg-amber-400" />
                                    <span className="h-3 w-3 rounded-full bg-rose-400" />
                                </div>
                            </div>

                            <div className="space-y-4">
                                {highlights.map(item => (
                                    <div
                                        key={item.title}
                                        className="rounded-[24px] border border-white/10 bg-white/6 p-4"
                                    >
                                        <div className="flex items-start justify-between gap-4">
                                            <div>
                                                <div className="text-lg font-semibold text-white">{item.title}</div>
                                                <div className="mt-1 text-sm leading-6 text-slate-300">{item.text}</div>
                                            </div>
                                            <span className="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-cyan-100">
                                                {item.badge}
                                            </span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

const root = document.getElementById('frontend-root');

if (root) {
    ReactDOM.createRoot(root).render(
        <React.StrictMode>
            <App />
        </React.StrictMode>,
    );
}
