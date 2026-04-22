<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Tenant;
use App\Models\WhatsappTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(): View
    {
        $tenants = Tenant::query()->orderBy('name')->get();
        $emailTemplates = EmailTemplate::query()->with('tenant')->latest()->get();
        $whatsappTemplates = WhatsappTemplate::query()->with('tenant')->latest()->get();

        return view('admin.templates.index', compact('tenants', 'emailTemplates', 'whatsappTemplates'));
    }

    public function storeWhatsapp(Request $request): JsonResponse
    {
        $template = WhatsappTemplate::query()
            ->create($this->validatedWhatsappData($request))
            ->load('tenant');

        return response()->json([
            'message' => 'Template de WhatsApp salvo com sucesso.',
            'record_id' => $template->id,
            'row_html' => view('admin.templates.partials.whatsapp-row', compact('template'))->render(),
        ]);
    }

    public function updateWhatsapp(Request $request, WhatsappTemplate $whatsappTemplate): JsonResponse
    {
        $whatsappTemplate->update($this->validatedWhatsappData($request));
        $whatsappTemplate->refresh()->load('tenant');

        return response()->json([
            'message' => 'Template de WhatsApp atualizado com sucesso.',
            'record_id' => $whatsappTemplate->id,
            'row_html' => view('admin.templates.partials.whatsapp-row', ['template' => $whatsappTemplate])->render(),
        ]);
    }

    public function destroyWhatsapp(WhatsappTemplate $whatsappTemplate): JsonResponse
    {
        $recordId = $whatsappTemplate->id;
        $whatsappTemplate->delete();

        return response()->json([
            'message' => 'Template de WhatsApp removido com sucesso.',
            'record_id' => $recordId,
        ]);
    }

    public function storeEmail(Request $request): JsonResponse
    {
        $template = EmailTemplate::query()
            ->create($this->validatedEmailData($request))
            ->load('tenant');

        return response()->json([
            'message' => 'Template de e-mail salvo com sucesso.',
            'record_id' => $template->id,
            'row_html' => view('admin.templates.partials.email-row', compact('template'))->render(),
        ]);
    }

    public function updateEmail(Request $request, EmailTemplate $emailTemplate): JsonResponse
    {
        $emailTemplate->update($this->validatedEmailData($request));
        $emailTemplate->refresh()->load('tenant');

        return response()->json([
            'message' => 'Template de e-mail atualizado com sucesso.',
            'record_id' => $emailTemplate->id,
            'row_html' => view('admin.templates.partials.email-row', ['template' => $emailTemplate])->render(),
        ]);
    }

    public function destroyEmail(EmailTemplate $emailTemplate): JsonResponse
    {
        $recordId = $emailTemplate->id;
        $emailTemplate->delete();

        return response()->json([
            'message' => 'Template de e-mail removido com sucesso.',
            'record_id' => $recordId,
        ]);
    }

    protected function validatedWhatsappData(Request $request): array
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'type' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    protected function validatedEmailData(Request $request): array
    {
        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'type' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:180'],
            'body' => ['required', 'string'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
