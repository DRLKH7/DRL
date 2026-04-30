import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Link, useNavigate, useLocation } from 'react-router-dom';
import {
    Shield, Activity, Target, AlertTriangle, FileText, Settings, Search, CheckCircle2,
    ChevronRight, Eye, LogIn, User, Book, Lock, Info, X, Download, Terminal,
    LayoutDashboard, History, LogOut, ShieldAlert, BadgeInfo
} from 'lucide-react';
import logo from './assets/logo.png';

const API_BASE = import.meta.env.VITE_API_URL || "http://127.0.0.1:8000/api";

// --- CSS ANIMATIONS ---
const styles = `
.corvus-card {
  background: #1a1a1a;
  border: 1px solid rgba(198, 40, 40, 0.15);
  backdrop-filter: blur(10px);
}
.corvus-card:hover {
  border-color: rgba(198, 40, 40, 0.4);
}
`;

// --- GLOBAL COMPONENTS ---

const DisclaimerPopup = () => {
    const [show, setShow] = useState(false);
    useEffect(() => {
        const agreed = localStorage.getItem('corvus_agreed');
        if (!agreed) setShow(true);
    }, []);

    const handleAgree = () => {
        localStorage.setItem('corvus_agreed', 'true');
        setShow(false);
    };

    if (!show) return null;

    return (
        <div className="fixed inset-0 z-[999] flex items-center justify-center p-6 bg-black/90 backdrop-blur-xl animate-in fade-in duration-700">
            <div className="corvus-card w-full max-w-2xl rounded-[40px] shadow-[0_0_50px_rgba(220,38,38,0.2)] overflow-hidden">
                <div className="p-10 text-center">
                    <div className="flex justify-center mb-6">
                        <div className="animate-pulse">
                            <img src={logo} alt="Corvus Logo" className="w-24 h-24 object-contain shadow-[0_0_30px_rgba(220,38,38,0.3)] rounded-3xl" />
                        </div>
                    </div>
                    <h2 className="text-4xl font-black text-white tracking-tighter mb-4 italic uppercase">Identity <span className="text-red-600 underline">Authorized</span></h2>
                    <div className="bg-red-950/20 border border-red-900/30 p-8 rounded-3xl text-red-200/80 font-medium leading-relaxed italic mb-8 text-sm">
                        "Dengan menekan tombol setuju, Anda memahami bahwa Corvus adalah alat audit keamanan tingkat lanjut. CorvusNoct tidak bertanggung jawab atas segala kerusakan atau tuntutan hukum akibat penggunaan yang tidak sah terhadap infrastruktur target."
                    </div>
                    <button
                        onClick={handleAgree}
                        className="w-full bg-red-600 hover:bg-white hover:text-red-900 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-red-600/20 active:scale-95 text-lg uppercase tracking-widest"
                    >
                        I AGREE & INITIALIZE
                    </button>
                </div>
            </div>
        </div>
    );
};

const Navbar = ({ user, onLogout }) => (
    <nav className="flex items-center justify-between mb-12 border-b border-red-900/20 pb-6 max-w-7xl mx-auto sticky top-0 z-50 bg-[#0f0f0f]/80 backdrop-blur-md">
        <div className="flex items-center gap-3">
            <Link to="/" className="flex items-center gap-3 group">
                <div className="group-hover:scale-110 transition-transform">
                    <img src={logo} alt="Corvus Logo" className="w-12 h-12 object-cover rounded-2xl shadow-[0_0_20px_rgba(220,38,38,0.3)]" />
                </div>
                <div>
                    <h1 className="text-2xl font-black tracking-tight text-white italic">CORVUS</h1>
                    <p className="text-[8px] text-red-500 font-bold tracking-[0.3em] uppercase">Automated Testing</p>
                </div>
            </Link>
        </div>
        <div className="flex items-center gap-8">
            <div className="hidden md:flex gap-8">
                <Link to="/" className="text-[10px] font-black text-slate-400 hover:text-red-500 transition-colors uppercase tracking-widest">Dashboard</Link>
                <Link to="/reports" className="text-[10px] font-black text-slate-400 hover:text-red-500 transition-colors uppercase tracking-widest">Reports</Link>
                <Link to="/docs" className="text-[10px] font-black text-slate-400 hover:text-red-500 transition-colors uppercase tracking-widest">Docs</Link>
            </div>
            {user ? (
                <div className="flex items-center gap-4">
                    <Link to="/profile" className="flex items-center gap-2 bg-red-600/10 border border-red-900/30 px-5 py-2.5 rounded-xl text-[10px] font-black text-red-500 hover:bg-red-600 hover:text-white transition-all uppercase tracking-widest italic">
                        <User className="w-3 h-3" /> {user.username}
                    </Link>
                    <button onClick={onLogout} className="text-slate-600 hover:text-red-500 transition-colors"><LogOut className="w-5 h-5" /></button>
                </div>
            ) : (
                <Link to="/login" className="bg-red-600 text-white px-6 py-2.5 rounded-xl text-[10px] font-black hover:bg-white hover:text-red-900 transition-all uppercase tracking-widest flex items-center gap-2 shadow-lg shadow-red-600/20 underline-offset-4">
                    <LogIn className="w-4 h-4" /> SECURE LOGIN
                </Link>
            )}
        </div>
    </nav>
);

const VulnDetailModal = ({ finding, onClose }) => {
    if (!finding) return null;
    return (
        <div className="fixed inset-0 z-[1000] flex items-center justify-center p-6 bg-black/95 backdrop-blur-sm animate-in fade-in duration-300">
            <div className="bg-[#0a0505] border border-red-900/30 w-full max-w-3xl rounded-[48px] shadow-2xl p-12 relative overflow-hidden">
                <button onClick={onClose} className="absolute top-8 right-8 text-slate-500 hover:text-red-500"><X className="w-8 h-8" /></button>
                <div className="flex items-center gap-6 mb-10">
                    <div className="p-3 rounded-3xl border border-red-600/30 bg-red-950/20"><img src={logo} alt="L" className="w-14 h-14 object-contain" /></div>
                    <div>
                        <h3 className="text-4xl font-black text-white italic uppercase leading-none">{finding.name}</h3>
                        <div className="flex items-center gap-3 mt-2">
                            <span className="bg-red-600 text-white text-[10px] px-2 py-0.5 rounded-md font-bold">{finding.owasp_code || "A00:2021"}</span>
                            <p className="text-xs font-black text-red-500 uppercase tracking-widest">{finding.category}</p>
                        </div>
                    </div>
                </div>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div><h4 className="text-[10px] font-black text-slate-500 uppercase underline decoration-red-600 mb-4">PoC Points</h4><ul className="space-y-3">{finding.points.map((p, i) => (<li key={i} className="text-xs text-slate-400 font-bold italic">• {p}</li>))}</ul></div>
                    <div><h4 className="text-[10px] font-black text-slate-500 uppercase underline decoration-red-600 mb-4">Remediation</h4><div className="bg-red-950/10 border border-red-900/20 p-6 rounded-3xl text-xs font-bold text-red-200/60 leading-relaxed italic">{finding.remediation}</div><div className="mt-6 flex justify-between items-center"><span className="text-[9px] font-black text-slate-600 uppercase">CVSS Score</span><span className="text-3xl font-black text-red-600">{finding.cvss}</span></div></div>
                </div>
            </div>
        </div>
    );
};

const Dashboard = ({ user }) => {
    const [target, setTarget] = useState("");
    const [isScanning, setIsScanning] = useState(false);
    const [activeScan, setActiveScan] = useState(null);
    const [showDetail, setShowDetail] = useState(null);

    const handleScan = async (e) => {
        e.preventDefault();
        setIsScanning(true);
        const res = await fetch(`${API_BASE}/scan`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ target, mode: "core" })
        });
        const data = await res.json();
        setActiveScan(data);
    };

    useEffect(() => {
        let interval;
        if (activeScan && (activeScan.status === "RUNNING" || activeScan.status === "PENDING")) {
            interval = setInterval(() => {
                fetch(`${API_BASE}/scan/${activeScan.id}`).then(r => r.json()).then(d => {
                    setActiveScan(d);
                    if (d.status === 'COMPLETED' || d.status === 'FAILED') setIsScanning(false);
                });
            }, 2000);
        }
        return () => clearInterval(interval);
    }, [activeScan]);

    return (
        <div className="space-y-8 animate-in fade-in duration-1000">
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div className="lg:col-span-8">
                    <section className="corvus-card p-10 rounded-[40px] shadow-2xl relative overflow-hidden group">
                        <h2 className="text-2xl font-black mb-8 flex items-center gap-3 text-white italic">
                            <Target className="w-6 h-6 text-red-600" />
                            INITIATE AUDIT CENTER
                        </h2>
                        <form onSubmit={handleScan} className="space-y-8">
                            <div className="relative">
                                <input
                                    type="text"
                                    placeholder="Enter target (e.g., identity.corvus.net)"
                                    className="w-full bg-black/60 border border-slate-800 rounded-3xl py-6 px-8 pl-16 text-xl focus:outline-none focus:border-red-600 transition-all text-white placeholder:text-slate-700"
                                    value={target}
                                    onChange={(e) => setTarget(e.target.value)}
                                    disabled={isScanning}
                                />
                                <Search className="absolute left-6 top-1/2 -translate-y-1/2 text-red-600 w-7 h-7" />
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div className="bg-black/40 p-5 rounded-2xl border border-slate-800 flex items-center justify-between">
                                    <span className="text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Phase</span>
                                    <select className="bg-transparent text-xs font-black text-red-600 focus:outline-none cursor-pointer uppercase">
                                        <option>Normal</option><option>Deep</option><option>Extreme</option>
                                    </select>
                                </div>
                                <div className="bg-black/40 p-5 rounded-2xl border border-slate-800 flex items-center justify-between">
                                    <span className="text-[10px] font-black text-slate-500 uppercase tracking-widest italic">Subdomains</span>
                                    <div className="w-4 h-4 bg-red-600 rounded flex items-center justify-center"><CheckCircle2 className="w-3 h-3 text-white" /></div>
                                </div>
                                <button
                                    type="submit"
                                    disabled={isScanning || !target}
                                    className="bg-red-600 hover:bg-white hover:text-red-900 text-white font-black py-5 px-8 rounded-2xl transition-all shadow-xl shadow-red-600/20 active:scale-95 disabled:grayscale uppercase tracking-widest text-xs"
                                >
                                    {isScanning ? 'SYSTEM RUNNING...' : 'LAUNCH CORVUS'}
                                </button>
                            </div>
                        </form>
                    </section>
                </div>

                <div className="lg:col-span-4">
                    <section className="corvus-card p-10 rounded-[40px] h-full flex flex-col justify-between">
                        <div>
                            <h2 className="text-xl font-black mb-8 flex items-center gap-3 text-white italic">
                                <Activity className="w-6 h-6 text-red-600" /> ACTIVE STATUS
                            </h2>
                            <div className="space-y-8">
                                <div className="flex flex-col gap-3">
                                    <div className="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                                        <span className="text-slate-500">Execution Progress</span>
                                        <span className="text-red-500">{activeScan?.progress || 0}%</span>
                                    </div>
                                    <div className="w-full bg-slate-950 rounded-full h-2 border border-slate-900 overflow-hidden">
                                        <div className="bg-red-600 h-full transition-all duration-700 shadow-[0_0_15px_#dc2626]" style={{ width: `${activeScan?.progress || 0}%` }} />
                                    </div>
                                </div>
                                <div className="flex items-center gap-4 bg-black/40 p-5 rounded-3xl border border-slate-800/50">
                                    <div className={`w-3 h-3 rounded-full ${isScanning ? 'bg-red-600 animate-pulse shadow-[0_0_10px_#dc2626]' : 'bg-green-500'}`} />
                                    <div className="flex flex-col">
                                        <span className="text-[9px] text-slate-600 font-black uppercase tracking-widest">Current Task</span>
                                        <span className="text-xs font-black text-white italic uppercase">{activeScan?.current_step || "IDLE"}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="mt-10 pt-8 border-t border-slate-800/50 grid grid-cols-2 gap-4 text-center">
                            <div className="p-4 bg-red-600/10 rounded-2xl border border-red-900/10">
                                <p className="text-2xl font-black text-red-600 tracking-tighter">{activeScan?.findings?.filter(f => f.severity === 'CRITICAL').length || 0}</p>
                                <p className="text-[8px] text-slate-600 uppercase font-black">Critical</p>
                            </div>
                            <div className="p-4 bg-orange-600/10 rounded-2xl border border-orange-900/10">
                                <p className="text-2xl font-black text-orange-600 tracking-tighter">{activeScan?.findings?.filter(f => f.severity === 'HIGH').length || 0}</p>
                                <p className="text-[8px] text-slate-600 uppercase font-black">High</p>
                            </div>
                            <div className="p-4 bg-yellow-600/10 rounded-2xl border border-yellow-900/10">
                                <p className="text-2xl font-black text-yellow-600 tracking-tighter">{activeScan?.findings?.filter(f => f.severity === 'MEDIUM').length || 0}</p>
                                <p className="text-[8px] text-slate-600 uppercase font-black">Medium</p>
                            </div>
                            <div className="p-4 bg-blue-600/10 rounded-2xl border border-blue-900/10">
                                <p className="text-2xl font-black text-blue-600 tracking-tighter">{activeScan?.findings?.filter(f => f.severity === 'LOW').length || 0}</p>
                                <p className="text-[8px] text-slate-600 uppercase font-black">Low</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <section className="corvus-card rounded-[48px] overflow-hidden shadow-2xl">
                <div className="p-10 border-b border-red-900/10 flex justify-between items-center bg-black/20">
                    <h2 className="text-2xl font-black flex items-center gap-4 text-white italic tracking-tighter">
                        <FileText className="w-7 h-7 text-red-600" /> VULNERABILITY ANALYSIS
                    </h2>
                </div>
                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead className="bg-black/40 text-red-900/60 text-[10px] font-black uppercase tracking-[0.2em] italic">
                            <tr>
                                <th className="px-10 py-6">Threat Type / ID</th>
                                <th className="px-10 py-6">Severity</th>
                                <th className="px-10 py-6">Endpoint / Vector</th>
                                <th className="px-10 py-6 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-red-900/5">
                            {!activeScan || !activeScan.findings || activeScan.findings.length === 0 ? (
                                <tr><td colSpan="4" className="px-10 py-32 text-center opacity-30 animate-pulse font-black uppercase text-[10px]">No threats detected yet</td></tr>
                            ) : (
                                activeScan.findings.map((res, i) => (
                                    <tr key={i} className="hover:bg-red-600/5 transition-colors group">
                                        <td className="px-10 py-7">
                                            <div className="flex items-center gap-4">
                                                <div className="w-10 h-10 rounded-2xl bg-red-600/10 flex items-center justify-center border border-red-600/20 group-hover:scale-110 transition-all">
                                                    <img src={logo} alt="L" className="w-6 h-6 object-contain" />
                                                </div>
                                                <div>
                                                     <div className="flex items-center gap-2 mb-1">
                                                         <span className="text-[7px] bg-red-600/20 text-red-500 px-1.5 py-0.5 rounded border border-red-900/30 font-bold">
                                                             {res.owasp_code || "A00:2021"} — {res.owasp || res.category}
                                                         </span>
                                                         <div className="text-[8px] font-black text-slate-600">{res.id}</div>
                                                     </div>
                                                     <div className="text-sm font-black text-white italic">{res.name}</div>
                                                 </div>
                                            </div>
                                        </td>
                                        <td className="px-10 py-7">
                                            <span className={`px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-tighter border ${
                                                    res.severity.toUpperCase() === 'CRITICAL' ? 'bg-[#b71c1c] text-white border-red-900 shadow-[0_0_10px_rgba(183,28,28,0.5)]' :
                                                    res.severity.toUpperCase() === 'HIGH' ? 'bg-[#e53935] text-white border-red-600' : 
                                                    res.severity.toUpperCase() === 'MEDIUM' ? 'bg-[#fb8c00] text-white border-orange-600' :
                                                    res.severity.toUpperCase() === 'LOW' ? 'bg-[#fdd835] text-black border-yellow-600' :
                                                    'bg-[#2196f3] text-white border-blue-600'
                                                }`}>{res.severity}</span>
                                        </td>
                                        <td className="px-10 py-7"><code className="text-[10px] bg-black px-4 py-2 rounded-xl border border-slate-800 text-red-400 font-mono italic">{res.location}</code></td>
                                        <td className="px-10 py-7 text-right">
                                            <button onClick={() => setShowDetail(res)} className="text-[10px] font-black text-red-600 hover:text-white uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">View Details →</button>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </section>

            <VulnDetailModal finding={showDetail} onClose={() => setShowDetail(null)} />
        </div>
    );
}

const ReportsPage = () => {
    const [reports, setReports] = useState([]);
    const [selectedReport, setSelectedReport] = useState(null);
    const [showDetail, setShowDetail] = useState(null);

    useEffect(() => { fetch(`${API_BASE}/reports`).then(r => r.json()).then(d => setReports(d)); }, []);

    return (
        <div className="py-20">
            <h2 className="text-5xl font-black text-white italic tracking-tighter mb-12 uppercase">Security <span className="text-red-600 underline">History</span></h2>

            {!selectedReport ? (
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {reports.map((h, i) => (
                        <div key={i} onClick={() => setSelectedReport(h)} className="corvus-card p-10 rounded-[48px] hover:border-red-600 transition-all shadow-2xl cursor-pointer group">
                            <History className="w-10 h-10 text-red-600 opacity-20 mb-6 group-hover:opacity-100 transition-opacity" />
                            <h4 className="text-2xl font-black text-white italic uppercase truncate mb-6">{h.target}</h4>
                            <div className="flex gap-8">
                                <div className="flex flex-col"><span className="text-[8px] font-black text-red-600 uppercase">Findings</span><span className="text-white font-black text-2xl">{h.findings?.length || 0}</span></div>
                                <div className="flex flex-col"><span className="text-[8px] font-black text-red-600 uppercase">Date</span><span className="text-slate-500 font-bold text-xs">{new Date(h.created_at).toLocaleDateString()}</span></div>
                            </div>
                            <div className="mt-8 pt-6 border-t border-red-900/10 flex justify-end">
                                <span className="text-[10px] font-black text-red-600 group-hover:translate-x-2 transition-transform italic uppercase">Open Report →</span>
                            </div>
                        </div>
                    ))}
                </div>
            ) : (
                <div className="space-y-8 animate-in fade-in duration-500">
                    <button onClick={() => setSelectedReport(null)} className="text-[10px] font-black text-slate-500 hover:text-red-600 uppercase tracking-widest flex items-center gap-2 mb-6 transition-colors">
                        ← BACK TO HISTORY
                    </button>
                    <div className="corvus-card rounded-[48px] overflow-hidden shadow-2xl">
                        <div className="p-10 border-b border-red-900/10 flex justify-between items-center bg-black/20">
                            <div>
                                <h3 className="text-3xl font-black text-white italic uppercase">{selectedReport.target}</h3>
                                <p className="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">Snapshot Audit: {new Date(selectedReport.created_at).toLocaleString()}</p>
                            </div>
                            <div className="flex gap-4">
                                <button 
                                    onClick={async () => {
                                        if (window.confirm("Are you sure you want to delete this report?")) {
                                            const res = await fetch(`${API_BASE}/reports/${selectedReport.id}`, { method: "DELETE" });
                                            if (res.ok) {
                                                setSelectedReport(null);
                                                fetch(`${API_BASE}/reports`).then(r => r.json()).then(d => setReports(d));
                                            }
                                        }
                                    }}
                                    className="bg-slate-900 text-slate-500 p-3 rounded-2xl hover:bg-red-600 hover:text-white transition-all shadow-lg relative z-50 group cursor-pointer"
                                >
                                    <X className="w-5 h-5 group-active:scale-90 transition-transform" />
                                </button>
                                <button 
                                    onClick={() => {
                                        const reportData = JSON.stringify(selectedReport, null, 4);
                                        const blob = new Blob([reportData], { type: 'application/json' });
                                        const url = window.URL.createObjectURL(blob);
                                        const link = document.createElement('a');
                                        link.href = url;
                                        link.setAttribute('download', `corvus_${selectedReport.target}_${selectedReport.id.slice(0,8)}.json`);
                                        document.body.appendChild(link);
                                        link.click();
                                        document.body.removeChild(link);
                                        window.URL.revokeObjectURL(url);
                                    }}
                                    className="bg-red-600 text-white p-3 rounded-2xl hover:bg-white hover:text-red-900 transition-all shadow-lg shadow-red-600/40 relative z-50 group cursor-pointer"
                                >
                                    <Download className="w-5 h-5 group-active:scale-90 transition-transform" />
                                </button>
                            </div>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="w-full text-left">
                                <thead className="bg-black/40 text-red-900/60 text-[10px] font-black uppercase tracking-[0.2em] italic">
                                    <tr>
                                        <th className="px-10 py-6">Threat Type / ID</th>
                                        <th className="px-10 py-6">Severity</th>
                                        <th className="px-10 py-6">Endpoint</th>
                                        <th className="px-10 py-6 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-red-900/5">
                                    {selectedReport.findings.map((res, i) => (
                                        <tr key={i} className="hover:bg-red-600/5 transition-colors group">
                                            <td className="px-10 py-7">
                                                <div className="flex items-center gap-4">
                                                    <div className="w-10 h-10 rounded-2xl bg-red-600/10 flex items-center justify-center border border-red-600/20 group-hover:scale-110 transition-all">
                                                        <img src={logo} alt="L" className="w-6 h-6 object-contain" />
                                                    </div>
                                                    <div>
                                                     <div className="flex items-center gap-2 mb-1">
                                                         <span className="text-[7px] bg-red-600/20 text-red-500 px-1.5 py-0.5 rounded border border-red-900/30 font-bold">
                                                             {res.owasp_code || "A00:2021"} — {res.owasp || res.category}
                                                         </span>
                                                         <div className="text-[8px] font-black text-slate-600">{res.id}</div>
                                                     </div>
                                                     <div className="text-sm font-black text-white italic">{res.name}</div>
                                                 </div>
                                                </div>
                                            </td>
                                            <td className="px-10 py-7">
                                                <span className={`px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-tighter border ${
                                                    res.severity.toUpperCase() === 'CRITICAL' ? 'bg-[#b71c1c] text-white border-red-900 shadow-[0_0_10px_rgba(183,28,28,0.5)]' :
                                                    res.severity.toUpperCase() === 'HIGH' ? 'bg-[#e53935] text-white border-red-600' : 
                                                    res.severity.toUpperCase() === 'MEDIUM' ? 'bg-[#fb8c00] text-white border-orange-600' :
                                                    res.severity.toUpperCase() === 'LOW' ? 'bg-[#fdd835] text-black border-yellow-600' :
                                                    'bg-[#2196f3] text-white border-blue-600'
                                                }`}>{res.severity}</span>
                                            </td>
                                            <td className="px-10 py-7"><code className="text-[10px] bg-black px-4 py-2 rounded-xl border border-slate-800 text-red-400 font-mono italic">{res.location}</code></td>
                                            <td className="px-10 py-7 text-right">
                                                <button onClick={() => setShowDetail(res)} className="text-[10px] font-black text-red-600 hover:text-white uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">View Details →</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            )}
            <VulnDetailModal finding={showDetail} onClose={() => setShowDetail(null)} />
        </div>
    );
};

const LoginPage = ({ onLogin }) => {
    const [isReg, setIsReg] = useState(false);
    const [form, setForm] = useState({ username: '', password: '', email: '' });
    const navigate = useNavigate();
    const handleSubmit = async (e) => {
        e.preventDefault();
        const res = await fetch(`${API_BASE}${isReg ? '/auth/register' : '/auth/login'}`, { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(form) });
        if (res.ok) { if (!isReg) { const data = await res.json(); localStorage.setItem('corvus_token', data.access_token); onLogin(); navigate("/"); } else { setIsReg(false); } }
    };
    return (
        <div className="max-w-md mx-auto py-32 animate-in zoom-in duration-500">
            <div className="corvus-card p-12 rounded-[50px] shadow-2xl">
                <h2 className="text-3xl font-black text-white italic mb-10 uppercase tracking-tighter">{isReg ? 'New Identity' : 'SECURE ENTRY'}</h2>
                <form onSubmit={handleSubmit} className="space-y-6">
                    {isReg && <input type="email" placeholder="EMAIL" className="w-full bg-black/60 border border-slate-800 rounded-2xl p-4 text-xs font-bold text-white outline-none focus:border-red-600" onChange={(e) => setForm({ ...form, email: e.target.value })} />}
                    <input type="text" placeholder="USERNAME" className="w-full bg-black/60 border border-slate-800 rounded-2xl p-4 text-xs font-bold text-white outline-none focus:border-red-600" onChange={(e) => setForm({ ...form, username: e.target.value })} />
                    <input type="password" placeholder="PASSWORD" className="w-full bg-black/60 border border-slate-800 rounded-2xl p-4 text-xs font-bold text-white outline-none focus:border-red-600" onChange={(e) => setForm({ ...form, password: e.target.value })} />
                    <button className="w-full bg-red-600 text-white font-black py-4 rounded-2xl hover:bg-white hover:text-red-900 transition-all uppercase text-[10px] tracking-widest">Authorize</button>
                </form>
                <button onClick={() => setIsReg(!isReg)} className="w-full mt-6 text-[9px] font-black text-slate-600 uppercase tracking-widest hover:text-red-600">{isReg ? "LOGIN" : "REGISTER"}</button>
            </div>
        </div>
    );
};


const DocsPage = () => (
    <div className="py-20 max-w-6xl mx-auto space-y-24 animate-in fade-in slide-in-from-bottom duration-1000">
        <header className="text-center space-y-6">
            <h2 className="text-6xl font-black text-white italic tracking-tighter uppercase">CORVUS</h2>
            <p className="text-slate-500 font-bold tracking-[0.4em] uppercase text-xs">Automated Web Security Assessment Platform</p>
            <div className="flex justify-center gap-4 pt-4">
                <span className="px-4 py-1 bg-red-600/10 border border-red-600/30 rounded-full text-[9px] font-black text-red-500 uppercase tracking-widest">v2.1.0-RED</span>
                <span className="px-4 py-1 bg-green-600/10 border border-green-600/30 rounded-full text-[9px] font-black text-green-500 uppercase tracking-widest">MIT LICENSE</span>
                <span className="px-4 py-1 bg-blue-600/10 border border-blue-600/30 rounded-full text-[9px] font-black text-blue-500 uppercase tracking-widest">DOCKER READY</span>
            </div>
        </header>

        <section className="corvus-card p-16 rounded-[60px] shadow-2xl relative overflow-hidden group">
            <div className="absolute top-0 right-0 w-64 h-64 bg-red-600/5 blur-[100px] -z-10" />
            <h3 className="text-2xl font-black text-white italic mb-8 flex items-center gap-4 uppercase tracking-tighter">
                <div className="bg-red-600 p-2 rounded-xl"><Book className="w-5 h-5 text-white" /></div> 
                Gambaran Umum
            </h3>
            <p className="text-slate-400 text-sm leading-relaxed italic mb-12">
                Corvus adalah platform manajemen audit keamanan web otomatis yang dirancang untuk memberikan visibilitas mendalam terhadap postur risiko aset digital. Dibangun di atas fondasi modular, Corvus menggabungkan berbagai instrumen audit industri ke dalam satu orkestra cerdas untuk menghasilkan laporan kerentanan yang akurat, konsisten, dan dapat ditindaklanjuti.
            </p>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                {[
                    { t: "Inkonsistensi", s: "Idempotensi: Hasil reproduktif berbasis hashing." },
                    { t: "Destruktif", s: "Safe Probing: Audit aman tanpa eksploitasi." },
                    { t: "Overflow Data", s: "Deduplikasi: Eliminasi temuan redundan lintas scan." },
                    { t: "Silo Data", s: "Normalisasi: Satu format JSON standar untuk semua tool." }
                ].map((item, i) => (
                    <div key={i} className="bg-black/40 p-8 rounded-3xl border border-slate-800/50 hover:border-red-900/30 transition-all">
                        <span className="text-[10px] font-black text-red-600 uppercase tracking-widest mb-3 block italic">{item.t}</span>
                        <p className="text-xs text-white font-bold">{item.s}</p>
                    </div>
                ))}
            </div>
        </section>

        <section className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div className="corvus-card p-12 rounded-[50px]">
                <h3 className="text-xl font-black text-white italic mb-8 uppercase tracking-tighter">Fase Audit Sistem</h3>
                <div className="space-y-6">
                    {[
                        { f: "01 Recon", d: "DNS Discovery & Tech Stack mapping." },
                        { f: "02 Enum", d: "Port scanning & service identification." },
                        { f: "03 Disc", d: "Sensitive file & directory enumeration." },
                        { f: "04 Vuln", d: "Template-based vulnerability scanning." },
                        { f: "05 Safe", d: "Security headers, CORS & rate limit audit." }
                    ].map((f, i) => (
                        <div key={i} className="flex gap-6 items-start">
                            <span className="text-2xl font-black text-red-600/20 italic tabular-nums">{f.f.split(' ')[0]}</span>
                            <div>
                                <span className="text-[11px] font-black text-white uppercase tracking-widest">{f.f.split(' ')[1]}</span>
                                <p className="text-[10px] text-slate-500 font-bold italic mt-1">{f.d}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
            <div className="corvus-card p-12 rounded-[50px]">
                <h3 className="text-xl font-black text-white italic mb-8 uppercase tracking-tighter">API Integration</h3>
                <div className="space-y-8 text-xs">
                    <p className="text-slate-400 italic">Interaksi pihak ketiga melalui Official REST API Endpoint (127.0.0.1:8000).</p>
                    <div className="space-y-4">
                        <div className="bg-black p-6 rounded-3xl border border-slate-800">
                            <div className="flex justify-between mb-4">
                                <span className="bg-blue-600 text-[8px] font-black px-3 py-1 rounded-lg uppercase">POST /api/scan</span>
                                <span className="text-slate-600 italic text-[9px]">Initiate audit</span>
                            </div>
                            <code className="text-blue-400 block font-bold leading-relaxed tracking-wider">
                                {"{"} "target": "domain.com", "mode": "normal" {"}"}
                            </code>
                        </div>
                        <div className="bg-black p-6 rounded-3xl border border-slate-800">
                            <div className="flex justify-between mb-4">
                                <span className="bg-green-600 text-[8px] font-black px-3 py-1 rounded-lg uppercase">GET /api/scan/id</span>
                                <span className="text-slate-600 italic text-[9px]">Check progress</span>
                            </div>
                            <code className="text-green-400 block font-bold leading-relaxed tracking-wider">
                                status: "RUNNING", progress: 65
                            </code>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section className="bg-red-950/5 border border-red-900/20 p-16 rounded-[60px] text-center">
            <h3 className="text-xl font-black text-white italic mb-6 flex items-center justify-center gap-4 uppercase tracking-tighter">
                <Lock className="w-5 h-5 text-red-600" /> Aturan Etika & Batasan
            </h3>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                {[
                    { t: "Otorisasi", d: "Izin tertulis wajib sebelum audit." },
                    { t: "No Exploit", d: "Pemetaan kerentanan tanpa merusak layanan." },
                    { t: "Blokir IP", d: "IP Privat (SSRF prevention) diblokir sistem." }
                ].map((e, i) => (
                    <div key={i}>
                        <h4 className="text-[10px] font-black text-red-600 uppercase mb-2 italic underline underline-offset-4">{e.t}</h4>
                        <p className="text-[11px] text-slate-500 font-bold italic">{e.d}</p>
                    </div>
                ))}
            </div>
            <div className="mt-12 bg-black/40 p-6 rounded-3xl border border-red-900/10 max-w-2xl mx-auto italic text-[10px] text-red-200/40 leading-loose">
                "Pengoperasian Corvus Red Edition diatur oleh hukum yang berlaku. CorvusNoct tidak bertanggung jawab atas segala penyalahgunaan infrastruktur yang melanggar hukum."
            </div>
        </section>
    </div>
);

const PrivacyPage = () => (
    <div className="py-20 max-w-4xl animate-in fade-in duration-700">
        <h2 className="text-5xl font-black text-white italic tracking-tighter mb-10 uppercase">Privacy <span className="text-red-600 underline">Policy</span></h2>
        <div className="bg-slate-950/40 p-12 rounded-[50px] border border-red-900/20 text-slate-400 space-y-8 italic">
            <p className="text-sm font-bold leading-loose">Corvus beroperasi dalam lingkungan mandiri (standalone). Kami tidak membagikan atau mengirimkan data audit Anda ke server eksternal mana pun di luar infrastruktur lokal Anda.</p>
            <div>
                <h4 className="text-white font-black uppercase mb-2">Data Collection</h4>
                <p className="text-xs">Kami hanya menyimpan riwayat scan (target, tanggal, temuan) secara lokal di database internal Anda untuk kebutuhan pelaporan Anda sendiri.</p>
            </div>
            <div>
                <h4 className="text-white font-black uppercase mb-2">Security Measures</h4>
                <p className="text-xs">Semua data sensitif dilindungi dengan enkripsi level database dan kontrol akses JWT pada API Backend.</p>
            </div>
        </div>
    </div>
);

const TermsPage = () => (
    <div className="py-20 max-w-4xl animate-in fade-in duration-700">
        <h2 className="text-5xl font-black text-white italic tracking-tighter mb-10 uppercase">Terms of <span className="text-red-600 underline">Service</span></h2>
        <div className="bg-red-950/10 p-12 rounded-[50px] border border-red-900/20 text-red-200/60 space-y-8 italic">
            <p className="text-sm font-bold leading-relaxed">PENGGUNAAN ALAT INI DIATUR OLEH HUKUM YANG BERLAKU DI WILAYAH ANDA. PENGGUNAAN CORVUS UNTUK AKTIVITAS ILEGAL SANGAT DILARANG.</p>
            <ol className="list-decimal pl-6 space-y-4 text-xs font-bold">
                <li>Anda wajib memiliki izin eksplisit sebelum memindai infrastruktur apa pun.</li>
                <li>CorvusNoct tidak bertanggung jawab atas penyalahgunaan atau kerusakan yang diakibatkan oleh sistem ini.</li>
                <li>Segala hasil audit adalah rahasia pengguna dan tanggung jawab pengguna sepenuhnya.</li>
            </ol>
        </div>
    </div>
);

function App() {
    const [user, setUser] = useState(null);
    useEffect(() => { const token = localStorage.getItem('corvus_token'); if (token) fetchMe(token); }, []);
    const fetchMe = async (token) => {
        const res = await fetch(`${API_BASE}/auth/me`, { headers: { "Authorization": `Bearer ${token}` } });
        if (res.ok) { setUser(await res.json()); } else { localStorage.removeItem('corvus_token'); }
    };
    return (
        <Router>
            <style>{styles}</style>
            <div className="min-h-screen text-slate-300 px-8 py-10 selection:bg-red-600 selection:text-white relative overflow-hidden">
                <DisclaimerPopup />
                <Navbar user={user} onLogout={() => { localStorage.removeItem('corvus_token'); setUser(null); }} />
                <main className="max-w-7xl mx-auto min-h-[70vh] relative z-10">
                    <Routes>
                        <Route path="/" element={<Dashboard user={user} />} />
                        <Route path="/reports" element={<ReportsPage />} />
                        <Route path="/docs" element={<DocsPage />} />
                        <Route path="/privacy" element={<PrivacyPage />} />
                        <Route path="/terms" element={<TermsPage />} />
                        <Route path="/login" element={<LoginPage onLogin={() => fetchMe(localStorage.getItem('corvus_token'))} />} />
                    </Routes>
                </main>
                <footer className="max-w-7xl mx-auto mt-32 pt-10 border-t border-red-900/10 flex justify-between items-center text-[9px] font-black uppercase tracking-widest text-slate-600">
                    <div>© 2024 CORVUSNOCT • STANDALONE SYSTEM</div>
                    <div className="flex gap-10"><Link to="/privacy" className="hover:text-red-500 transition-colors">Privacy</Link><Link to="/terms" className="hover:text-red-500 transition-colors">Terms</Link></div>
                </footer>
            </div>
        </Router>
    );
}

export default App;
