import React, { useState, useEffect } from 'react';
import { Shield, Activity, Target, AlertTriangle, FileText, Settings, Search, CheckCircle2 } from 'lucide-react';

const App = () => {
    const [scanTarget, setScanTarget] = useState('corvusnoct.my.id');
    const [isScanning, setIsScanning] = useState(false);
    const [progress, setProgress] = useState(0);
    const [status, setStatus] = useState('Idle');
    const [results, setResults] = useState([]);

    const handleScan = async (e) => {
        e.preventDefault();
        if (!scanTarget) return;

        setIsScanning(true);
        setStatus('Initializing Scan...');
        setProgress(5);

        // Simulation for now
        setTimeout(() => { setStatus('Reconnaissance...'); setProgress(15); }, 2000);
        setTimeout(() => { setStatus('Discovery...'); setProgress(35); }, 5000);
        setTimeout(() => { setStatus('Vuln Scanning...'); setProgress(65); }, 10000);
        setTimeout(() => { 
            setStatus('Completed'); 
            setProgress(100);
            setIsScanning(false);
            setResults([
                { id: 1, type: 'XSS', severity: 'HIGH', endpoint: '/search?q=', confidence: 0.95 },
                { id: 2, type: 'Sensitive Data', severity: 'MEDIUM', endpoint: '/js/app.js', confidence: 0.85 }
            ]);
        }, 15000);
    };

    return (
        <div className="min-h-screen bg-slate-950 text-slate-200 font-sans p-6 overflow-x-hidden">
            {/* Background Decorations */}
            <div className="absolute top-0 right-0 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] -z-10" />
            <div className="absolute bottom-0 left-0 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[120px] -z-10" />

            <nav className="flex items-center justify-between mb-12 border-b border-slate-800 pb-6 max-w-7xl mx-auto">
                <div className="flex items-center gap-3">
                    <div className="bg-indigo-600 p-2 rounded-xl shadow-[0_0_20px_rgba(79,70,229,0.4)]">
                        <Shield className="w-8 h-8 text-white" />
                    </div>
                    <div>
                        <h1 className="text-2xl font-bold tracking-tight bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">CORVUS</h1>
                        <p className="text-xs text-slate-500 font-medium tracking-widest uppercase">Automated Pentest Platform</p>
                    </div>
                </div>
                <div className="flex gap-4">
                    <button className="px-4 py-2 text-sm font-medium text-slate-400 hover:text-white transition-colors">Dashboard</button>
                    <button className="px-4 py-2 text-sm font-medium text-slate-400 hover:text-white transition-colors">Reports</button>
                    <button className="bg-indigo-600/10 text-indigo-400 border border-indigo-500/20 px-6 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-600/20 transition-all">My Account</button>
                </div>
            </nav>

            <main className="max-w-7xl mx-auto space-y-8">
                {/* Header Section */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <div className="lg:col-span-8">
                        <section className="bg-slate-900/50 backdrop-blur-xl border border-slate-800 p-8 rounded-3xl shadow-2xl">
                            <h2 className="text-xl font-bold mb-6 flex items-center gap-2">
                                <Target className="w-5 h-5 text-indigo-400" />
                                Initiate New Scan
                            </h2>
                            <form onSubmit={handleScan} className="space-y-6">
                                <div className="relative">
                                    <input 
                                        type="text" 
                                        placeholder="Enter target domain (e.g., corvusnoct.my.id)"
                                        className="w-full bg-slate-950/80 border border-slate-700 rounded-2xl py-4 px-6 pl-14 text-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder:text-slate-600"
                                        value={scanTarget}
                                        onChange={(e) => setScanTarget(e.target.value)}
                                        disabled={isScanning}
                                    />
                                    <Search className="absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 w-6 h-6" />
                                </div>
                                
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div className="bg-slate-950/40 p-4 rounded-xl border border-slate-800 flex items-center justify-between">
                                        <span className="text-sm text-slate-400">Scan Mode</span>
                                        <select className="bg-transparent text-sm font-semibold focus:outline-none cursor-pointer">
                                            <option>Quick</option>
                                            <option selected>Normal</option>
                                            <option>Deep</option>
                                        </select>
                                    </div>
                                    <div className="bg-slate-950/40 p-4 rounded-xl border border-slate-800 flex items-center justify-between">
                                        <span className="text-sm text-slate-400">Include Subdomains</span>
                                        <input type="checkbox" defaultChecked className="w-4 h-4 accent-indigo-500" />
                                    </div>
                                    <button 
                                        type="submit" 
                                        disabled={isScanning || !scanTarget}
                                        className="bg-indigo-600 hover:bg-indigo-500 disabled:bg-slate-800 disabled:text-slate-500 text-white font-bold py-4 px-8 rounded-2xl transition-all shadow-lg shadow-indigo-600/20 active:scale-95"
                                    >
                                        {isScanning ? 'Scanning...' : 'Launch Corvus'}
                                    </button>
                                </div>
                                <div className="flex items-center gap-3 bg-red-950/20 border border-red-900/30 p-4 rounded-xl">
                                    <AlertTriangle className="w-5 h-5 text-red-500 shrink-0" />
                                    <p className="text-xs text-red-200/60 leading-relaxed">
                                        I confirm I have explicit authorization to scan this target. Corvus is not responsible for any misuse of results.
                                        <input type="checkbox" className="ml-3 accent-red-500" required />
                                    </p>
                                </div>
                            </form>
                        </section>
                    </div>

                    <div className="lg:col-span-4">
                        <section className="bg-slate-900/50 backdrop-blur-xl border border-slate-800 p-8 rounded-3xl h-full flex flex-col justify-between">
                            <div>
                                <h2 className="text-xl font-bold mb-6 flex items-center gap-2">
                                    <Activity className="w-5 h-5 text-indigo-400" />
                                    Active Status
                                </h2>
                                <div className="space-y-6">
                                    <div className="flex flex-col gap-2">
                                        <div className="flex justify-between items-center text-sm">
                                            <span className="text-slate-400">Overall Progress</span>
                                            <span className="font-mono text-indigo-400">{progress}%</span>
                                        </div>
                                        <div className="w-full bg-slate-950 rounded-full h-3 border border-slate-800 overflow-hidden">
                                            <div 
                                                className="bg-gradient-to-r from-indigo-600 to-blue-500 h-full transition-all duration-500 ease-out shadow-[0_0_10px_rgba(79,70,229,0.5)]"
                                                style={{ width: `${progress}%` }}
                                            />
                                        </div>
                                    </div>
                                    
                                    <div className="flex items-center gap-4 bg-slate-950/60 p-4 rounded-2xl border border-slate-800/50">
                                        <div className={`w-3 h-3 rounded-full ${isScanning ? 'bg-amber-500 animate-pulse' : 'bg-green-500'} shadow-[0_0_8px_rgba(245,158,11,0.5)]`} />
                                        <div className="flex flex-col">
                                            <span className="text-[10px] text-slate-500 font-bold uppercase tracking-wide">Current Task</span>
                                            <span className="text-sm font-medium">{status}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div className="mt-8 pt-6 border-t border-slate-800/50">
                                <div className="grid grid-cols-2 gap-4 text-center">
                                    <div className="p-3">
                                        <p className="text-2xl font-bold text-red-500">0</p>
                                        <p className="text-[10px] text-slate-500 uppercase font-bold">Critical</p>
                                    </div>
                                    <div className="p-3">
                                        <p className="text-2xl font-bold text-amber-500">{results.filter(r => r.severity === 'HIGH').length}</p>
                                        <p className="text-[10px] text-slate-500 uppercase font-bold">High Risk</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                {/* Results Section */}
                <section className="bg-slate-900/50 backdrop-blur-xl border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                    <div className="p-8 border-b border-slate-800 flex justify-between items-center bg-slate-900/30">
                        <h2 className="text-xl font-bold flex items-center gap-3">
                            <FileText className="w-5 h-5 text-indigo-400" />
                            Vulnerability Analysis
                        </h2>
                        <div className="flex gap-2">
                            <button className="text-xs bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-lg font-bold transition-all border border-slate-700">Export JSON</button>
                            <button className="text-xs bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 hover:bg-indigo-600/30 px-4 py-2 rounded-lg font-bold transition-all">Download PDF</button>
                        </div>
                    </div>
                    <div className="overflow-x-auto">
                        <table className="w-full text-left">
                            <thead className="bg-slate-950/50 text-slate-500 text-xs font-bold uppercase tracking-wider">
                                <tr>
                                    <th className="px-8 py-4">Threat Type</th>
                                    <th className="px-8 py-4">Severity</th>
                                    <th className="px-8 py-4">Endpoint / Resource</th>
                                    <th className="px-8 py-4">Confidence</th>
                                    <th className="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-800/50">
                                {results.length === 0 ? (
                                    <tr>
                                        <td colSpan="5" className="px-8 py-20 text-center text-slate-600">
                                            <div className="flex flex-col items-center gap-4">
                                                <div className="p-4 bg-slate-950 rounded-full border border-slate-800">
                                                    <Activity className="w-8 h-8 text-slate-800" />
                                                </div>
                                                <p className="text-sm font-medium tracking-wide">No scan data available...</p>
                                            </div>
                                        </td>
                                    </tr>
                                ) : (
                                    results.map(res => (
                                        <tr key={res.id} className="hover:bg-slate-800/30 transition-colors group">
                                            <td className="px-8 py-5">
                                                <div className="flex items-center gap-3">
                                                    <div className="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20">
                                                        <Shield className="w-4 h-4 text-indigo-400" />
                                                    </div>
                                                    <span className="font-bold text-slate-200">{res.type}</span>
                                                </div>
                                            </td>
                                            <td className="px-8 py-5">
                                                <span className={`px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter ${
                                                    res.severity === 'HIGH' ? 'bg-red-500/10 text-red-500 border border-red-500/20' : 
                                                    'bg-amber-500/10 text-amber-500 border border-amber-500/20'
                                                }`}>
                                                    {res.severity}
                                                </span>
                                            </td>
                                            <td className="px-8 py-5">
                                                <code className="text-xs bg-slate-950 px-3 py-1.5 rounded-lg border border-slate-800 text-indigo-300 font-mono">{res.endpoint}</code>
                                            </td>
                                            <td className="px-8 py-5">
                                                <div className="flex items-center gap-2">
                                                    <div className="w-full max-w-[60px] bg-slate-950 h-1.5 rounded-full overflow-hidden border border-slate-800">
                                                        <div className="bg-green-500 h-full" style={{ width: `${res.confidence * 100}%` }} />
                                                    </div>
                                                    <span className="text-xs font-mono text-slate-500">{(res.confidence * 100).toFixed(0)}%</span>
                                                </div>
                                            </td>
                                            <td className="px-8 py-5 text-right">
                                                <button className="text-xs font-bold text-indigo-400 hover:text-white underline underline-offset-4 decoration-indigo-500/30 transition-all opacity-0 group-hover:opacity-100">View Details</button>
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>

            <footer className="max-w-7xl mx-auto mt-20 pt-8 border-t border-slate-800/50 flex flex-col md:flex-row justify-between items-center gap-6 text-slate-500 bg-slate-950/50 backdrop-blur-sm p-8 rounded-t-3xl">
                <div className="flex items-center gap-6">
                    <span className="text-xs hover:text-slate-300 cursor-pointer transition-colors">Documentation</span>
                    <span className="text-xs hover:text-slate-300 cursor-pointer transition-colors">Privacy Policy</span>
                    <span className="text-xs hover:text-slate-300 cursor-pointer transition-colors">Terms of Service</span>
                </div>
                <div className="text-[10px] uppercase font-bold tracking-[0.2em] flex items-center gap-2">
                    <CheckCircle2 className="w-3 h-3 text-green-500" />
                    System Status: <span className="text-green-500">Operational</span>
                </div>
                <p className="text-xs">© 2024 CORVUS SEC • Automated Security Intelligence</p>
            </footer>
        </div>
    );
};

export default App;
